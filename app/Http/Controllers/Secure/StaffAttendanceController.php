<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\AddStaffAttendanceRequest;
use App\Http\Requests\Secure\DeleteRequest;
use App\Http\Requests\Secure\AttendanceGetRequest;
use App\Models\StaffAttendance;
use App\Models\TeacherSchool;
use App\Repositories\OptionRepository;
use App\Repositories\StaffAttendanceRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherSchoolRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Session;
use Datatables;
use Illuminate\Support\Collection;

class StaffAttendanceController extends SecureController
{

    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var StaffAttendanceRepository
     */
    private $staffAttendanceRepository;
	/**
	 * @var TeacherSchoolRepository
	 */
	private $teacherSchoolRepository;

	/**
	 * StaffAttendanceController constructor.
	 *
	 * @param OptionRepository $optionRepository
	 * @param UserRepository $userRepository
	 * @param StaffAttendanceRepository $staffAttendanceRepository
	 * @param TeacherSchoolRepository $teacherSchoolRepository
	 */
    public function __construct(OptionRepository $optionRepository,
                                UserRepository $userRepository,
                                StaffAttendanceRepository $staffAttendanceRepository,
	                            TeacherSchoolRepository $teacherSchoolRepository)
    {
        parent::__construct();

        view()->share('type', 'staff_attendance');
        $this->optionRepository = $optionRepository;
        $this->userRepository = $userRepository;
        $this->staffAttendanceRepository = $staffAttendanceRepository;
	    $this->teacherSchoolRepository = $teacherSchoolRepository;
    }

    public function index()
    {
        $title = trans('staff_attendance.attendances');
        $users = $this->list_of_users();
        $options = $this->optionRepository->getAllForSchool(session('current_school'))
            ->where('category', 'attendance_type')->get()
            ->map(function ($option) {
                return [
                    "title" => $option->title,
                    "value" => $option->id,
                ];
            })->pluck('title', 'value')->toArray();

        return view('staff_attendance.index', compact('title', 'users', 'options'));
    }

    public function addAttendance(AddStaffAttendanceRequest $request)
    {
        if (isset($request['users'])) {
            foreach ($request['users'] as $user_id) {
                $attendance = new StaffAttendance($request->except('users'));
                $attendance->user_id = $user_id;
                $attendance->school_year_id = session('current_school_year');
                $attendance->school_id = session('current_school');
                $attendance->save();
            }
        }
    }

    public function attendanceForDate(AttendanceGetRequest $request)
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')) {
		    $attendances = $this->staffAttendanceRepository->getAllForSchoolSchoolYear( Session::get( 'current_school'), Session::get( 'current_school_year' ) );
	    }else{
		    $attendances = $this->staffAttendanceRepository->getAllForSchoolYear( Session::get( 'current_school_year' ) );
	    }
            $attendances = $attendances->with('user', 'option')
            ->get()
            ->filter(function ($attendance) use ($request) {
                return (Carbon::createFromFormat(Settings::get('date_format'), $attendance->date) ==
                    Carbon::createFromFormat(Settings::get('date_format'), $request->date));
            })
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'name' => $attendance->user->full_name,
                    'option' => $attendance->option->title,
                ];
            })->toArray();
        return json_encode($attendances);
    }

    public function deleteattendance(DeleteRequest $request)
    {
        $attendance = StaffAttendance::find($request['id']);
        $attendance->delete();
    }

    public function list_of_users()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;
	    if($one_school &&  $this->user->inRole('accountant')) {
		    $teachers = $this->teacherSchoolRepository->getAllForSchool(session('current_school') )
		                                     ->map(function ($user) {
			                                     return [
				                                     'id' => $user->id,
				                                     'name' => $user->full_name,
			                                     ];
		                                     })
		                                     ->pluck('name', 'id')
		                                     ->toArray();
		    return $teachers;
	    }else {
		    $teachers        = $this->userRepository->getUsersForRole( 'teacher' )
		                                            ->map( function ( $user ) {
			                                            return [
				                                            'id'   => $user->id,
				                                            'name' => $user->full_name,
			                                            ];
		                                            } )
		                                            ->pluck( 'name', 'id' )
		                                            ->toArray();
		    $human_resources = $this->userRepository->getUsersForRole( 'human_resources' )
		                                            ->map( function ( $user ) {
			                                            return [
				                                            'id'   => $user->id,
				                                            'name' => $user->full_name,
			                                            ];
		                                            } )
		                                            ->pluck( 'name', 'id' )
		                                            ->toArray();
		    $admins          = $this->userRepository->getUsersForRole( 'admin' )
		                                            ->map( function ( $user ) {
			                                            return [
				                                            'id'   => $user->id,
				                                            'name' => $user->full_name,
			                                            ];
		                                            } )
		                                            ->pluck( 'name', 'id' )
		                                            ->toArray();
		    $accountant      = $this->userRepository->getUsersForRole( 'accountant' )
		                                            ->map( function ( $user ) {
			                                            return [
				                                            'id'   => $user->id,
				                                            'name' => $user->full_name,
			                                            ];
		                                            } )
		                                            ->pluck( 'name', 'id' )
		                                            ->toArray();

		    return $teachers + $human_resources + $admins + $accountant;
	    }
    }

}
