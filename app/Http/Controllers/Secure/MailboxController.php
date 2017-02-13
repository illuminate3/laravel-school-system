<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\MessageRequest;
use App\Models\Message;
use App\Models\User;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Sentinel;
use Session;

class MailboxController extends SecureController
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;

    /**
     * @param UserRepository $userRepository
     * @param StudentRepository $studentRepository
     * @param SubjectRepository $subjectRepository
     * @internal param CompanyRepository $
     */
    public function __construct(UserRepository $userRepository,
                                StudentRepository $studentRepository,
                                SubjectRepository $subjectRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;

        view()->share('type', 'mailbox');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('mailbox.mailbox');


        return view('mailbox.index', compact('title'));
    }

    public function getAllData()
    {
        $email_list = Message::where('to', $this->user->id)->whereNull('deleted_at_receiver')->orderBy('id', 'desc')->get();
        $sent_email_list = Message::where('from', $this->user->id)->whereNull('deleted_at_sender')->orderBy('id', 'desc')->get();

        if ($this->user->inRole('super_admin') || $this->user->inRole('librarian')
            || $this->user->inRole('accountant') || $this->user->inRole('human_resources')
        ) {
            list($users, $users_list) = $this->super_admin_contact_users();
        } elseif ($this->user->inRole('admin')) {
            list($users, $users_list) = $this->admin_contact_users();
        } elseif ($this->user->inRole('teacher')) {
            list($users, $users_list) = $this->teacher_contact_users();
        } elseif ($this->user->inRole('student')) {
            list($users, $users_list) = $this->student_contact_users();
        } elseif ($this->user->inRole('parent')) {
            list($users, $users_list) = $this->parent_contact_users();
        } else {
            $users = array();

            $users_list = array();
        }
        return response()->json(compact('email_list', 'sent_email_list', 'users', 'users_list'), 200);
    }


    public function getMail($id)
    {
        $email = Message::with('sender')->find($id);
        $email->read = 1;
        $email->save();

        return response()->json(compact('email'), 200);
    }

    function sendEmail(MessageRequest $request)
    {
        $message_return = '<div class="alert alert-danger">' . trans('mailbox.danger') . '</div>';
        if (!empty($request->recipients)) {
            foreach ($request->recipients as $item) {
                if ($item != "0" && $item != "") {
                    $email = new Message($request->except('recipients', 'emailTemplate'));
                    $email->to = $item;
                    $email->from = $this->user->id;
                    $email->save();

                    $user = User::find($item);

                    if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
                        Mail::send('emails.contact', array('user' => $user->first_name . ' ' . $user->last_name, 'bodyMessage' => $request->message),
                            function ($m)
                            use ($user, $request) {
                                $m->from(Settings::get('site_email'), Settings::get('site_name'));
                                $m->to($user->email)->subject($request->subject);
                            });
                    }

                    $message_return = '<div class="alert alert-success">' . trans('mailbox.success') . '</div>';
                }

            }
        }
        echo $message_return;

    }

    function deleteMail(Message $mail)
    {
        if ($mail->to == $this->user->id) {
            $mail->deleted_at_receiver = Carbon::now();
        } else {
            $mail->deleted_at_sender = Carbon::now();
        }
        $mail->save();
    }


    public function postRead(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $model = Message::find($request->get('id'));
        $model->read = true;
        $model->save();

        return response()->json(['message' => trans('mailbox.update_status')], 200);
    }


    public function getData()
    {
        $emails_list = Message::where('to', $this->user->id)
            ->whereNull('deleted_at_receiver')
            ->where('read', 0)
            ->with('sender')
            ->orderBy('id', 'desc');

        $total = $emails_list->count();
        $emails = $emails_list->latest()->take(5)->get();

        return response()->json(compact('total', 'emails'), 200);
    }

    public function postMarkAsRead(Request $request)
    {
        if ($ids = $request->get('ids')) {
            if (is_array($ids)) {
                $messages = Message::whereIn('id', $ids)->get();
                foreach ($messages as $message) {
                    $message->read = true;
                    $message->save();
                }
            } else {
                $message = Message::find($ids);
                $message->read = true;
                $message->save();
            }
        }
    }

    public function getSent()
    {
        $sent = Message::where('from', $this->user->id)
            ->whereNull('deleted_at_sender')
            ->with('receiver')
            ->orderBy('id', 'desc')->get();

        return response()->json(compact('sent'), 200);
    }

    public function getReceived(Request $request)
    {
        $received_list = Message::where('to', $this->user->id)
            ->whereNull('deleted_at_receiver')
            ->where('subject', 'like', '%' . $request->get('query', '') . '%')
            ->where('message', 'like', '%' . $request->get('query', '') . '%')
            ->with('sender');
        $received = $received_list->orderBy('id', 'desc')->get();
        $received_count = $received_list->count();
        return response()->json(compact('received', 'received_count'), 200);
    }


    public function postSend(Request $request)
    {
        foreach ($request->recipients as $item) {
            if ($item != "0" && $item != "") {
                $email = new Message($request->except('recipients'));
                $email->to = $item;
                $email->from = \Sentinel::getUser()->id;
                $email->save();

                $user = User::find($item);

                if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
                    Mail::send('emails.contact', array('user' => $user->full_name, 'bodyMessage' => $request->message),
                        function ($m)
                        use ($user, $request) {
                            $m->from(Settings::get('site_email'), Settings::get('site_name'));
                            $m->to($user->email)->subject($request->subject);
                        });
                }
            }
        }

        return response()->json(['message' => 'Message sent successfully!'], 200);

    }

    public function postDelete(Request $request)
    {
        if ($ids = $request->get('ids')) {
            if (is_array($ids)) {
                $messages = Message::whereIn('id', $ids)->get();
                foreach ($messages as $message) {
                    $message->deleted_at_receiver = Carbon::now();
                    $message->save();
                }
            } else {
                $message = Message::find($ids);
                $message->deleted_at_receiver = Carbon::now();
                $message->save();
            }
        }
    }

    public function postReply($id, Request $request)
    {
        $orgMail = Message::find($id);

        $request->merge([
            'subject' => 'Re: ' . $orgMail->subject,
        ]);

        $email = new Message($request->all());
        $email->to = $orgMail->from;
        $email->from = Sentinel::getUser()->id;
        $email->save();

        $user = User::find($orgMail->from);


        if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            Mail::send('emails.contact', array('user' => $user->full_name, 'bodyMessage' => $request->message),
                function ($m)
                use ($user, $request) {
                    $m->from(Settings::get('site_email'), Settings::get('site_name'));
                    $m->to($user->email)->subject($request->subject);
                });
        }

    }

    /**
     * @return array
     */
    private function super_admin_contact_users()
    {
        $users = $this->userRepository->getAll()
            ->where('id', '<>', $this->user->id)->get()
            ->filter(function ($user) {
                return ($user->inRole('admin') || $user->inRole('librarian')
                    || $user->inRole('human_resources') || $user->inRole('accountant'));
            })
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->full_name,
                ];
            })->values();

        $users_list = $this->userRepository->getAll()
            ->where('id', '<>', $this->user->id)->get()
            ->filter(function ($user) {
                return ($user->inRole('admin') || $user->inRole('librarian')
                    || $user->inRole('human_resources') || $user->inRole('accountant'));
            })
            ->map(function ($user) {
                return [
                    'full_name' => $user->full_name,
                    'user_avatar' => $user->user_avatar,
                    'active' => (isset($user->last_login) && $user->last_login >= Carbon::now()->subMinutes('15')->toDateTimeString()) ? '1' : '0',
                ];
            });
        return array($users, $users_list);
    }

    /**
     * @return array
     */
    private function admin_contact_users()
    {
        $users = $this->userRepository->getAll()
            ->where('id', '<>', $this->user->id)->get()
            ->filter(function ($user) {
                return ($user->inRole('super_user') || $user->inRole('librarian') ||
                    $user->inRole('human_resources') || $user->inRole('accountant'));
            })
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->full_name,
                ];
            })->values();

        $users_list = $this->userRepository->getAll()
            ->where('id', '<>', $this->user->id)->get()
            ->filter(function ($user) {
                return ($user->inRole('super_user') || $user->inRole('librarian') ||
                    $user->inRole('human_resources') || $user->inRole('accountant'));
            })
            ->map(function ($user) {
                return [
                    'full_name' => $user->full_name,
                    'user_avatar' => $user->user_avatar,
                    'active' => (isset($user->last_login) && $user->last_login >= Carbon::now()->subMinutes('15')->toDateTimeString()) ? '1' : '0',
                ];
            });
        return array($users, $users_list);
    }

    /**
     * @return array
     */
    private function teacher_contact_users()
    {
        $users = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->map(function ($student) {
                return [
                    'id' => $student->user->id,
                    'text' => $student->user->full_name,
                ];
            })->values();

        $users_list = $this->studentRepository->getAllForStudentGroup(session('current_student_group'))
            ->map(function ($student) {
                return [
                    'full_name' => $student->user->full_name,
                    'user_avatar' => $student->user->user_avatar,
                    'active' => (isset($student->user->last_login) && $student->user->last_login >= Carbon::now()->subMinutes('15')->toDateTimeString()) ? '1' : '0',
                ];
            });
        return array($users, $users_list);
    }

    /**
     * @return array
     */
    private function student_contact_users()
    {
        $users = $this->subjectRepository
            ->getAllStudentsSubjectsTeacher($this->user->id, session('current_school_year'))
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name,
                ];
            })->values();

        $users_list = $this->subjectRepository
            ->getAllStudentsSubjectsTeacher($this->user->id, session('current_school_year'))
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name,
                    'active' => (isset($user->last_login) && $user->last_login >= Carbon::now()->subMinutes('15')->toDateTimeString()) ? '1' : '0',
                ];
            });
        return array($users, $users_list);
    }

    /**
     * @return array
     */
    private function parent_contact_users()
    {
        $users = $this->subjectRepository
            ->getAllStudentsSubjectsTeacher(session('current_student_user_id'), session('current_school_year'))
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name,
                ];
            })->values();

        $users_list = $this->subjectRepository
            ->getAllStudentsSubjectsTeacher(session('current_student_user_id'), session('current_school_year'))
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name,
                    'active' => (isset($user->last_login) && $user->last_login >= Carbon::now()->subMinutes('15')->toDateTimeString()) ? '1' : '0',
                ];
            });
        return array($users, $users_list);
    }

}
