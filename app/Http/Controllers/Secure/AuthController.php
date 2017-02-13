<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\Thumbnail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordConfirmRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\ProfileChangeRequest;
use App\Http\Requests\Secure\UserRequest;
use App\Models\CertificateUser;
use App\Models\Email;
use App\Models\LoginHistory;
use App\Models\Student;
use App\Models\StudentRegistrationCode;
use App\Models\User;
use App\Models\Version;
use App\Models\Visitor;
use Illuminate\Support\Facades\Mail;
use Reminder;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Sentinel;
use Session;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use App\Http\Controllers\Traits\SharedValuesTrait;

class AuthController extends Controller
{
    use SharedValuesTrait;
    protected $redirectTo = '/';

    public function index()
    {
        if (Sentinel::check()) {
            return redirect("/");
        }
        return view('login');
    }

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getSignin()
    {
        if (Sentinel::check()) {
            return redirect("/");
        }
        return view('login');
    }

    /**
     * Account sign up.
     *
     * @return View
     */
    public function getSignup()
    {
        if (Sentinel::check()) {
            return redirect("/");
        }
        return view('register');
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postSignin(LoginRequest $request)
    {
        try {
            if ($user = Sentinel::authenticate($request->only('email', 'password'), $request->has('remember'))) {
                Flash::success(trans('auth.signin_success'));

                $this->shareValues();

                $userLogin = new LoginHistory();
                $userLogin->user_id = $user->id;
                $userLogin->ip_address = $request->ip();
                $userLogin->save();

                return redirect("/");
            }
            Flash::error(trans('auth.login_params_not_valid'));
        } catch (NotActivatedException $e) {
            Flash::error(trans('auth.account_not_activated'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            Flash::error(trans('auth.account_suspended') . $delay . trans('auth.second'));
        }
        return back()->withInput();
    }
    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postSignup(UserRequest $request)
    {
        $registration_code = StudentRegistrationCode::where('code', $request->get('registration_code'))->first();
        if(!is_null($registration_code) || !(Settings::get('generate_registration_code')==true &&
                                                Settings::get('self_registration_role')=='student')) {
            try {
                $user = Sentinel::registerAndActivate(array(
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                ));
                $role = Sentinel::findRoleBySlug(Settings::get('self_registration_role'));
                if (isset($role)) {
                    $role->users()->attach($user);

                    if (Settings::get('self_registration_role') == 'visitor') {
                        $visitor = new Visitor();
                        $visitor->user_id = $user->id;
                        $visitor->save();

                        $visitor->visitor_no = Settings::get('visitor_card_prefix') . $visitor->id;
                        $visitor->save();
                    }else if(Settings::get('generate_registration_code')==true &&
                        Settings::get('self_registration_role')=='student'){
                        Student::create(['school_year_id'=>$registration_code->school_year_id,
                            'user_id'=>$user->id,
                            'section_id'=>$registration_code->section_id,
                            'school_id'=>$registration_code->school_id]);

                        $registration_code->delete();
                    }
                }

                Sentinel::loginAndRemember($user);

                Flash::success(trans('auth.signup_success'));
                return redirect('/');

            } catch (UserExistsException $e) {
                Flash::warning(trans('auth.account_already_exists'));
            }
            return back()->withInput();
        }else{
            Flash::warning(trans('auth.registration_code_is_not_valid'));
            return back()->withInput();
        }
    }

    public function reminders()
    {
        return view('reminders.create');
    }

    public function remindersStore(PasswordResetRequest $request)
    {

        $userFind = User::where('email', $request->email)->first();
        if (isset($userFind->id)) {
            $user = Sentinel::findById($userFind->id);
            ($reminder = Reminder::exists($user)) || ($reminder = Reminder::create($user));

            $data = [
                'email' => $user->email,
                'name' => $userFind->full_name,
                'subject' => trans('auth.reset_your_password'),
                'code' => $reminder->code,
                'id' => $user->id
            ];
            Mail::queue('emails.reminder', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])->subject($data['subject']);
            });

            Session::flash('email_message_success', trans("auth.reset_password_link_send"));
            return back();
        }
        Session::flash('email_message_warning', trans("auth.user_dont_exists"));
        return back();
    }

    public function edit($id, $code)
    {
        $user = Sentinel::findById($id);
        if (Reminder::exists($user, $code)) {
            return view('reminders.edit', ['id' => $id, 'code' => $code]);
        } else {
            return redirect('/signin');
        }
    }

    public function update($id, $code, PasswordConfirmRequest $request)
    {
        $user = Sentinel::findById($id);
        $reminder = Reminder::exists($user, $code);
        //incorrect info was passed.
        if ($reminder == false) {
            Flash::error(trans("auth.reset_password_failed"));
            return redirect('/');
        }
        Reminder::complete($user, $code, $request->password);
        Flash::success(trans("auth.reset_password_success"));
        return redirect('/signin');
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        Sentinel::logout(null, true);
        Flash::success(trans('auth.successfully_logout'));
        Session::flush();
        return redirect('signin');
    }

    /**
     * Profile page.
     *
     * @return Redirect
     */
    public function getProfile()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }

        $title = trans('auth.user_profile');
        $user = User::find(Sentinel::getUser()->id);
        $version = Version::first()->version;
        return view('profile', compact('title', 'user', 'version'));
    }

    public function getAccount()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $title = trans('auth.edit_profile');
        $version = Version::first()->version;
        $user = User::find(Sentinel::getUser()->id);

        return view('account', compact('title', 'user', 'version'));
    }

    public function postAccount(ProfileChangeRequest $request)
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }

        $user = User::find(Sentinel::getUser()->id);
        if ($request->hasFile('user_avatar_file') != "") {
            $file = $request->file('user_avatar_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
        }
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->update($request->except('user_avatar_file', 'password', 'password_confirmation'));
        Flash::success(trans('auth.successfully_change_profile'));
        return redirect('profile');
    }

    public function postWebcam(Request $request)
    {
        $user = User::find(Sentinel::getUser()->id);
        if (isset($request['photo_url'])) {
            $output_file = uniqid() . ".jpg";
            $ifp = fopen(public_path() . '/uploads/avatar/' . $output_file, "wb");
            $data = explode(',', $request['photo_url']);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            $user->picture = $output_file;
        }
        $user->update($request->except('photo_url', 'password', 'password_confirmation'));
    }

    public function getCertificate()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $version = Version::first()->version;
        $user = User::find(Sentinel::getUser()->id);
        $certificates = CertificateUser::join('certificates', 'certificates.id', '=', 'certificate_user.certificate_id')
            ->whereNull('certificate_user.deleted_at')
            ->where('user_id', $user->id)
            ->select('certificates.*')->get();
        $title = trans('auth.my_certificate');
        return view('certificate', compact('title', 'certificates', 'user', 'version'));
    }

	public function loginAsUser(Request $request, User $user)
	{
	    if(Sentinel::getUser()->inRole('super_admin')){
            session(['was_super_admin' => Sentinel::getUser()->id]);
        }else if(Sentinel::getUser()->inRole('super_admin')) {
            session(['was_admin' => Sentinel::getUser()->id]);
        }else{
            return back();
        }

		$user = Sentinel::findById($user->id);
		Sentinel::login($user);

		return redirect("/");
	}

	public function backToAdmin(Request $request)
	{
        if(is_null(session('was_admin'))) {
            $user = Sentinel::findById(session('was_admin'));
            Sentinel::login($user);
        }

		return redirect("/");
	}

    public function setYear($id)
    {
        session(['current_school_year' => $id]);
        return redirect('/');
    }

    public function setSchool($id)
    {
        session(['current_school' => $id]);
        return redirect('/');
    }

    public function setGroup($id)
    {
        session(['current_student_group' => $id]);
        return redirect('/');
    }

    public function setStudent($id)
    {
        session(['current_student_id' => $id]);
        return redirect('/');
    }

}
