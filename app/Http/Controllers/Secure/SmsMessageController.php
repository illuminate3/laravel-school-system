<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\SmsMessageRequest;
use App\Models\SmsMessage;
use App\Models\User;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSubjectRepository;
use App\Repositories\SmsMessageRepository;
use Datatables;
use Session;
use SMS;

class SmsMessageController extends SecureController
{
    /**
     * @var SmsMessageRepository
     */
    private $smsMessageRepository;
    /**
     * @var TeacherSubjectRepository
     */
    private $teacherSubjectRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @param SmsMessageRepository $smsMessageRepository
     * @param TeacherSubjectRepository $teacherSubjectRepository
     * @param StudentRepository $studentRepository
     */
    public function __construct(SmsMessageRepository $smsMessageRepository,
                                TeacherSubjectRepository $teacherSubjectRepository,
                                StudentRepository $studentRepository)
    {
        parent::__construct();

        $this->smsMessageRepository = $smsMessageRepository;
        $this->teacherSubjectRepository = $teacherSubjectRepository;
        $this->studentRepository = $studentRepository;

        $this->middleware('authorized:sms_message.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:sms_message.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:sms_message.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:sms_message.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'sms_message');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('sms_message.sms_messages');
        return view('sms_message.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('sms_message.new');
        $teachers = $this->teacherSubjectRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('teacher')
            ->get()
            ->filter(function ($teacher) {
                return (isset($teacher->teacher) &&
                    isset($teacher->teacher->mobile) &&
                    $teacher->teacher->mobile != "" &&
                    (!isset($teacher->teacher->get_sms) || $teacher->teacher->get_sms == 1));
            })
            ->map(function ($teacher) {
                return [
                    'user_id' => $teacher->teacher_id,
                    'full_name' => $teacher->teacher->full_name,
                ];
            })->pluck('full_name', 'user_id')->toArray();

        $students = $this->studentRepository->getAllForSchoolYearAndSchool(session('current_school_year'), session('current_school'))
            ->with('user')
            ->get()
            ->filter(function ($student) {
                return (isset($student->user) &&
                    isset($student->user->mobile) &&
                    $student->user->mobile != "" &&
                    (!isset($student->user->get_sms) || $student->user->get_sms == 1));
            })
            ->map(function ($student) {
                return [
                    'user_id' => $student->user_id,
                    'full_name' => $student->user->full_name,
                ];
            })->pluck('full_name', 'user_id')->toArray();
        $users = array();
        foreach ($teachers as $key => $item) {
            $users[$key] = $item;
        }
        foreach ($students as $key => $item) {
            $users[$key] = $item;
        }

        return view('layouts.create', compact('title', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(SmsMessageRequest $request)
    {
        if (count($request->users_select) > 0) {
            foreach ($request->users_select as $item) {
                $user = User::find($item);
                $smsMessage = new SmsMessage();
                $smsMessage->text = $request->text;
                $smsMessage->number = $user->mobile;
                $smsMessage->user_id = $item;
                $smsMessage->user_id_sender = $this->user->id;
                $smsMessage->save();

                SMS::send($request->text, [], function ($sms) use ($user) {
                    $sms->to($user->mobile);
                });
            }
        }
        return redirect('/sms_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(SmsMessage $smsMessage)
    {
        $title = trans('sms_message.details');
        $action = 'show';
        return view('layouts.show', compact('smsMessage', 'title', 'action', 'receivers'));
    }

    public function data()
    {
        $messages = $this->smsMessageRepository->getAllForSender($this->user->id)
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'text' => $message->text,
                ];
            });

        return Datatables::of($messages)
            ->add_column('actions', '<a href="{{ url(\'/sms_message/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
            ->remove_column('id')
            ->make();
    }
}
