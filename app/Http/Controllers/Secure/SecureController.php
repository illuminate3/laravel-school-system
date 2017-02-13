<?php

namespace App\Http\Controllers\Secure;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Blog;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Diary;
use App\Models\Direction;
use App\Models\Exam;
use App\Models\Faq;
use App\Models\GetBook;
use App\Models\Holiday;
use App\Models\Invoice;
use App\Models\Mark;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\Option;
use App\Models\Page;
use App\Models\Payment;
use App\Models\ReturnBook;
use App\Models\Salary;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\StaffAttendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherSchool;
use App\Models\TeacherSubject;
use App\Models\Transportation;
use App\Models\User;
use App\Models\Version;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Session;
use App\Http\Controllers\Traits\SharedValuesTrait;
use Calendar;
use Laracasts\Flash\Flash;

class SecureController extends Controller
{
    use SharedValuesTrait;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Sentinel::check()) {
                $this->user = User::find(Sentinel::getUser()->id);
                if (!isset($this->user)) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.account_deleted'));

                    return redirect()->guest('/');
                }
                view()->share('user', $this->user);

                $version = isset(Version::first()->version) ? Version::first()->version : 1;
                view()->share('version', $version);

                $transportations = Transportation::count();
                view()->share('transportations', $transportations);

                $this->shareValues();

            } else {
                Sentinel::logout(null, true);
            }

            return $next($request);
        });
    }


    public function showHome()
    {
        if (Sentinel::check()) {
            if ($this->user->inRole('super_admin')) {
                if ($this->user->inRole('admin') && Settings::get('multi_school') == 'no') {
                    list($sections, $teachers, $parents, $directions, $per_month, $per_school_year,$students_by_gender,
                        $teachers_by_gender) = $this->admin_dashboard();
                    return view('dashboard.admin', compact('sections', 'teachers', 'parents', 'directions', 'per_month',
                        'per_school_year','students_by_gender','teachers_by_gender'));
                }else {
                    list($schools, $teachers, $parents, $directions) = $this->super_admin_dashboard();
                    return view('dashboard.super_admin', compact('schools', 'teachers', 'parents', 'directions'));
                }
            } elseif ($this->user->inRole('admin')) {
                list($sections, $teachers, $parents, $directions, $per_month, $per_school_year,$students_by_gender,
                    $teachers_by_gender) = $this->admin_dashboard();
                return view('dashboard.admin', compact('sections', 'teachers', 'parents', 'directions', 'per_month',
                    'per_school_year','students_by_gender','teachers_by_gender'));
            } elseif ($this->user->inRole('human_resources')) {
                list($schools, $teachers, $parents, $directions, $per_month) = $this->human_resources_dashboard();
                return view('dashboard.human_resources', compact('schools', 'teachers', 'parents', 'directions', 'per_month'));
            } elseif ($this->user->inRole('teacher')) {
                list($teachergroups, $subjects, $diaries, $exams, $attendances_count) = $this->teacher_dashboard();
                return view('dashboard.teacher', compact('teachergroups', 'subjects', 'diaries', 'exams', 'attendances_count'));
            } elseif ($this->user->inRole('librarian')) {
                list($books_total, $issued_books, $reserved_books, $book_categories) = $this->librarian_dashboard();
                $books = array(array('title' => trans('dashboard.total_books'), 'items' => $books_total, 'color' => "#fd9883"),
                    array('title' => trans('dashboard.issued_books'), 'items' => $issued_books, 'color' => "#c2185b"),
                    array('title' => trans('dashboard.reserved_books'), 'items' => $reserved_books, 'color' => "#00796b"));
                return view('dashboard.librarian', compact('books', 'book_categories'));
            } elseif ($this->user->inRole('student')) {
                list($borrowed_books, $dairies, $attendances, $marks, $attendances_count, $attendance_count_by_subject) = $this->student_dashboard();
                return view('dashboard.student', compact('borrowed_books', 'dairies', 'attendances', 'marks',
                    'attendances_count', 'attendance_count_by_subject'));
            } elseif ($this->user->inRole('parent')) {
                list($borrowed_books, $dairies, $attendances, $marks, $attendances_count, $attendance_count_by_subject) = $this->parent_dashboard();
                return view('dashboard.parent', compact('borrowed_books', 'dairies', 'attendances', 'marks',
                    'attendances_count', 'attendance_count_by_subject'));
            } elseif ($this->user->inRole('accountant')) {
                list($per_month, $per_school_year, $teachers) = $this->accountant_dashboard();
                return view('dashboard.accountant', compact('per_month', 'per_school_year', 'teachers'));
            }
            return view('dashboard.index');
        } else {
            if(Page::count() == 0){
                if(Blog::count()>0){
                    return redirect('blogs')->send();
                }elseif(Settings::get('about_school_page') == 'yes'){
                    return redirect('about_school_page')->send();
                }elseif(Settings::get('about_teachers_page') == 'yes'){
                    return redirect('about_teachers_page')->send();
                }elseif(Settings::get('show_contact_page') == 'yes'){
                    return redirect('contact')->send();
                }elseif(Faq::count()>0){
                    return redirect('faqs')->send();
                }else{
                    return redirect('signin')->send();
                }
            }
            $first = Page::first();
            return redirect('page/'.$first->slug)->send();
        }
    }

    public function events()
    {
        $data = array();
        if ($this->user->inRole('student')) {
            $data = Notice::where("user_id", $this->user->id)
                ->select(array('id', "title", "date", "description"))
                ->get()->toArray();
        } else {
            if ($this->user->inRole('parent')) {
                $user = User::find(session('current_student_user_id'));
                if (isset($user)) {
                    $data = Notice::where("user_id", $user->id)
                        ->select(array('id', "title", "date", "description"))
                        ->get()->toArray();
                }
            } else {
                $data = Notification::where("user_id", $this->user->id)
                    ->select(array('id', "title", "date", "content as description"))
                    ->get()->toArray();
            }
        }
        if (!is_null(session('current_school'))) {
            $holidays = Holiday::where('school_id', session('current_school'))
                ->select(array('id', "title", "date", "title as description"))
                ->get()->toArray();

        } else {
            $holidays = Holiday::select(array('id', "title", "date", "title as description"))
                ->get()->toArray();
        }
        $events = [];
        $items = array_merge($holidays, $data);

        if (isset($items)) {
            foreach ($items as $d) {
                $date = Carbon::createFromFormat(Settings::get('date_format'), $d['date'])->format('Y-m-d');

                $event = [];
                $event["id"] = $d['id'];
                $event['title'] = $d['title'];
                $event['end'] = $date;
                $event['start'] = $date;
                $event['allDay'] = true;
                $event['description'] = $d['description'];
                array_push($events, $event);
            }
        }

        return json_encode($events);
    }

    /*
 * Matches each symbol of PHP date format standard
 * with jQuery equivalent codeword
 * @author Stojan Kukrika
 */
    function dateformat_PHP_to_jQueryUI($php_format)
    {
        $SYMBOLS_MATCHING = array(
            // Day
            'd' => 'DD',
            'D' => 'ddd',
            'j' => 'D',
            'l' => 'dddd',
            'N' => 'do',
            'S' => 'do',
            'w' => 'd',
            'z' => 'DDD',
            // Week
            'W' => 'w',
            // Month
            'F' => 'MMMM',
            'm' => 'MM',
            'M' => 'MMM',
            'n' => 'M',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'YYYY',
            'y' => 'YY',
            // Time
            'a' => 'a',
            'A' => 'A',
            'B' => '',
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => ''
        );


        $jqueryui_format = "";
        $escaping = false;
        for ($i = 0; $i < strlen($php_format); $i++) {
            $char = $php_format[$i];
            if ($char === '\\') // PHP date format escaping character
            {
                $i++;
                if ($escaping) $jqueryui_format .= $php_format[$i];
                else $jqueryui_format .= '\'' . $php_format[$i];
                $escaping = true;
            } else {
                if ($escaping) {
                    $jqueryui_format .= "'";
                    $escaping = false;
                }
                if (isset($SYMBOLS_MATCHING[$char]))
                    $jqueryui_format .= $SYMBOLS_MATCHING[$char];
                else
                    $jqueryui_format .= $char;
            }
        }
        return $jqueryui_format;
    }

    public function generateStudentNo($student_id, $school_id)
    {
        $school = School::find($school_id);
        return $school->student_card_prefix . $student_id;
    }

    //Dashboard methods for each role
    private function human_resources_dashboard()
    {
        list($schools, $teachers, $parents, $directions) = $this->super_admin_dashboard();

        $per_month = array();
        for ($i = 11; $i >= 0; $i--) {
            $per_month[] =
                array(
                    'month' => Carbon::now()->subMonth($i)->format('M'),
                    'year' => Carbon::now()->subMonth($i)->format('Y'),
                    'salary_by_month' => Salary::where(
                        'date',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('salary'),
                    'sum_of_payments' => Payment::where(
                        'created_at',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('amount'),
                    'sum_of_invoices' => Invoice::where(
                        'created_at',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('amount')
                );
        }
        return array($schools, $teachers, $parents, $directions, $per_month);
    }

    private function admin_dashboard()
    {
        $sections = Section::where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))->get();

        $teachers = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.slug', 'teacher')->count();

        $parents = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.slug', 'parent')->count();

        $directions = Direction::count();

        $per_month = array();
        for ($i = 11; $i >= 0; $i--) {
            $per_month[] =
                array(
                    'month' => Carbon::now()->subMonth($i)->format('M'),
                    'year' => Carbon::now()->subMonth($i)->format('Y'),
                    'salary_by_month' => Salary::where(
                        'date',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('salary'),
                    'sum_of_payments' => Payment::where(
                        'created_at',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('amount'),
                    'sum_of_invoices' => Invoice::where(
                        'created_at',
                        'LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m') . '%'
                    )->sum('amount')
                );
        }

        $per_school_year = array();
        $school_years = SchoolYear::all();
        foreach ($school_years as $school_year) {
            $per_school_year[] =
                array(
                    'school_year' => $school_year->title,
                    'number_of_students' => Student::where('school_year_id', $school_year->id)
                        ->where('school_id', session('current_school'))->count(),
                    'number_of_sections' => Section::where('school_year_id', $school_year->id)
                        ->where('school_id', session('current_school'))->count()
                );
        }
        $students_by_gender = Student::join('users','users.id', '=', 'students.user_id')
            ->where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->groupBy('users.gender')
            ->select(DB::raw(' count(users.id) as count'),'users.gender')->get()->toArray();
        foreach ($students_by_gender as &$item){
            $item['color'] = ($item['gender'] == 0)?"#0f85ad":"#c2185b";
            $item['gender'] = ($item['gender'] == 0)?trans("profile.male"):trans("profile.female");
        }

        $teachers_gender = TeacherSchool::join('users','users.id', '=', 'teacher_schools.user_id')
            ->where('school_id', session('current_school'))
            ->groupBy('users.gender')
            ->select(DB::raw(' count(users.id) as count'),'users.gender')->get()->toArray();
        foreach ($teachers_gender as &$item){
            $item['color'] = ($item['gender'] == 0)?"#155599":"#7c0d18";
            $item['gender'] = ($item['gender'] == 0)?trans("profile.male"):trans("profile.female");
        }
        return array($sections, $teachers, $parents, $directions, $per_month, $per_school_year,$students_by_gender,$teachers_gender);
    }

    private function super_admin_dashboard()
    {
        $schools = School::where('schools.active', 1)->get();

        $teachers = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.slug', 'teacher')->count();

        $parents = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.slug', 'parent')->count();

        $directions = Direction::count();
        return array($schools, $teachers, $parents, $directions);
    }

    /**
     * @return array
     */
    private function teacher_dashboard()
    {
        $teachergroups = TeacherSubject::join('student_groups', 'student_groups.id', '=', 'teacher_subjects.student_group_id')
            ->where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->where('teacher_id', $this->user->id)
            ->distinct('student_group_id');

        $subjects = TeacherSubject::where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->where('teacher_id', $this->user->id)
            ->distinct('subject_id')->count();

        $diaries = Diary::where('school_year_id', session('current_school_year'))
            ->where('school_id', session('current_school'))
            ->where('user_id', $this->user->id)->count();

        $exams = Exam::join('student_groups', 'student_groups.id', '=', 'exams.student_group_id')
            ->join('sections', 'sections.id', '=', 'student_groups.section_id')
            ->where('school_id', session('current_school'))
            ->where('user_id', $this->user->id)->count();

        $attendances_count = StaffAttendance::join('options', 'options.id', '=', 'staff_attendances.option_id')
            ->where('user_id', $this->user->id)
            ->where('staff_attendances.school_year_id', session('current_school_year'))
            ->groupBy('options.title')
            ->select(DB::raw('COUNT(staff_attendances.id) as count'), 'options.title')
            ->get();

        return array($teachergroups, $subjects, $diaries, $exams, $attendances_count);
    }

    /**
     * @return array
     */
    private function librarian_dashboard()
    {
        $books_total = Book::sum('quantity');
        $issued_books = GetBook::where('school_year_id', session('current_school_year'))->count('get_books_count')
            - ReturnBook::where('school_year_id', session('current_school_year'))->count('return_books_count');
        $reserved_books = BookUser::where('school_year_id', session('current_school_year'))->count();

        $book_categories = Option::where('school_id', 0)->where('category', 'book_category')->get();
        foreach ($book_categories as &$item) {
            $item->books = Book::where('option_id_category', $item->id)->count();
        }
        return array($books_total, $issued_books, $reserved_books, $book_categories);
    }

    /**
     * @return array
     */
    private function student_dashboard()
    {
        $borrowed_books = GetBook::where('user_id', $this->user->id)->count('get_books_count')
                - ReturnBook::where('user_id', $this->user->id)->count('return_books_count');
        $dairies = Diary::join('subjects', 'subjects.id', '=', 'diaries.subject_id')
            ->join('teacher_subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'teacher_subjects.student_group_id')
            ->join('students', 'students.id', '=', 'student_student_group.student_id')
            ->where('diaries.school_year_id', session('current_school_year'))
            ->where('students.user_id', $this->user->id)->count();

        $attendances = Attendance::join('students', 'students.id', '=', 'attendances.student_id')
            ->where('students.user_id', $this->user->id)
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('attendances.created_at', 'desc')
            ->select('attendances.date', 'attendances.hour')
            ->get();

        $marks = Mark::join('students', 'students.id', '=', 'marks.student_id')
            ->join('mark_types', 'mark_types.id', '=', 'marks.mark_type_id')
            ->join('mark_values', 'mark_values.id', '=', 'marks.mark_value_id')
            ->where('students.user_id', $this->user->id)
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('marks.created_at', 'desc')
            ->select('marks.date', 'mark_values.title as mark_value', 'mark_types.title as mark_type')
            ->get();

        $attendances_count = Attendance::join('students', 'students.id', '=', 'attendances.student_id')
            ->join('options', 'options.id', '=', 'attendances.option_id')
            ->where('students.user_id', $this->user->id)
            ->where('attendances.school_year_id', session('current_school_year'))
            ->groupBy('options.title')
            ->select(DB::raw('COUNT(attendances.id) as count'), 'options.title')
            ->get();

        $subjects = Subject::join('directions', 'subjects.direction_id', '=', 'directions.id')
            ->join('student_groups', function ($join) {
                $join->on('student_groups.direction_id', '=', 'directions.id');
                $join->on('student_groups.class', '=', 'subjects.class');
            })
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'student_groups.id')
            ->where('student_student_group.student_id', session('current_student_id'))
            ->orderBy('subjects.class')
            ->orderBy('subjects.order')
            ->select('subjects.id')->get()->toArray();

        $attendance_count_by_subject = [];
        foreach ($subjects as $subject) {
            foreach (Option::where('category', 'attendance_type')->select('id', 'title')->get() as $attendance_type)
                $attendance_count_by_subject[$subject->title][] =
                    array(
                        'number_of_attendances' =>  Attendance::join('options', 'options.id', '=', 'attendances.option_id')
                            ->where('attendances.student_id', session('current_student_id'))
                            ->where('attendances.subject_id', $subject->id)
                            ->where('option_id', $attendance_type->id)
                            ->count(),
                        'attendance_type' =>  $attendance_type->title
                    );
        }

        return array($borrowed_books, $dairies, $attendances, $marks, $attendances_count, $attendance_count_by_subject);
    }

    /**
     * @return array
     */
    private function parent_dashboard()
    {
        $borrowed_books = GetBook::where('user_id', $this->user->id)->count('get_books_count')
            - ReturnBook::where('user_id', $this->user->id)->count('return_books_count');
        $dairies = Diary::join('subjects', 'subjects.id', '=', 'diaries.subject_id')
            ->join('teacher_subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
            ->join('student_student_group', 'student_student_group.student_group_id', '=', 'teacher_subjects.student_group_id')
            ->join('students', 'students.id', '=', 'student_student_group.student_id')
            ->where('diaries.school_year_id', session('current_school_year'))
            ->where('students.user_id', session('current_student_user_id'))->count();

        $attendances = Attendance::join('students', 'students.id', '=', 'attendances.student_id')
            ->where('students.user_id', session('current_student_user_id'))
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('attendances.created_at', 'desc')
            ->select('attendances.date', 'attendances.hour')
            ->get();

        $marks = Mark::join('students', 'students.id', '=', 'marks.student_id')
            ->join('mark_types', 'mark_types.id', '=', 'marks.mark_type_id')
            ->join('mark_values', 'mark_values.id', '=', 'marks.mark_value_id')
            ->where('students.user_id', session('current_student_user_id'))
            ->where('students.school_year_id', session('current_school_year'))
            ->orderBy('marks.created_at', 'desc')
            ->select('marks.date', 'mark_values.title as mark_value', 'mark_types.title as mark_type')
            ->get();

        $attendances_count = Attendance::join('students', 'students.id', '=', 'attendances.student_id')
            ->join('options', 'options.id', '=', 'attendances.option_id')
            ->where('students.user_id', session('current_student_user_id'))
            ->where('attendances.school_year_id', session('current_school_year'))
            ->groupBy('options.title')
            ->select(DB::raw('COUNT(attendances.id) as count'), 'options.title')
            ->get();

        $subjects = Subject::join('directions', 'subjects.direction_id', '=', 'directions.id')
        ->join('student_groups', function ($join) {
            $join->on('student_groups.direction_id', '=', 'directions.id');
            $join->on('student_groups.class', '=', 'subjects.class');
        })
        ->join('student_student_group', 'student_student_group.student_group_id', '=', 'student_groups.id')
        ->where('student_student_group.student_id', session('current_student_id'))
        ->orderBy('subjects.class')
        ->orderBy('subjects.order')
        ->select('subjects.id','subjects.title')->get();

        $attendance_count_by_subject = [];
        foreach ($subjects as $subject) {
            foreach (Option::where('category', 'attendance_type')->select('id', 'title')->get() as $attendance_type)
            $attendance_count_by_subject[$subject->title][] =
                array(
                    'number_of_attendances' =>  Attendance::join('options', 'options.id', '=', 'attendances.option_id')
                        ->where('attendances.student_id', session('current_student_id'))
                        ->where('attendances.subject_id', $subject->id)
                        ->where('option_id', $attendance_type->id)
                        ->count(),
                    'attendance_type' =>  $attendance_type->title
                );
        }

        return array($borrowed_books, $dairies, $attendances, $marks, $attendances_count, $attendance_count_by_subject);
    }

    private function accountant_dashboard()
    {
	    $one_school = (Settings::get('account_one_school')=='yes')?true:false;

        $teachers = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('roles.slug', 'teacher');
		if($one_school){
			$teachers = $teachers->join('teacher_schools', 'teacher_schools.user_id', '=', 'users.id')
								->where('teacher_schools.school_id', session('current_school'));
		}
	    $teachers = $teachers->count();

        $per_month = array();
	    if($one_school) {
		    for ( $i = 11; $i >= 0; $i -- ) {
			    $per_month[] =
				    array (
					    'month'           => Carbon::now()->subMonth( $i )->format( 'M' ),
					    'year'            => Carbon::now()->subMonth( $i )->format( 'Y' ),
					    'salary_by_month' => Salary::where('date','LIKE',Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->where('school_id', session('current_school'))->sum( 'salary' ),
					    'sum_of_payments' => Payment::join('students', 'students.user_id', '=', 'payments.user_id')
						    ->where('payments.created_at','LIKE', Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->where('school_id', session('current_school'))->sum( 'amount' ),
					    'sum_of_invoices' => Invoice::join('students', 'students.user_id', '=', 'invoices.user_id')
						    ->where('invoices.created_at','LIKE', Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->where('school_id', session('current_school'))->sum( 'amount' )
				    );
		    }
	    }else{
		    for ( $i = 11; $i >= 0; $i -- ) {
			    $per_month[] =
				    array (
					    'month'           => Carbon::now()->subMonth( $i )->format( 'M' ),
					    'year'            => Carbon::now()->subMonth( $i )->format( 'Y' ),
					    'salary_by_month' => Salary::where('date','LIKE', Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->sum( 'salary' ),
					    'sum_of_payments' => Payment::where('created_at','LIKE',Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->sum( 'amount' ),
					    'sum_of_invoices' => Invoice::where('created_at','LIKE',Carbon::now()->subMonth( $i )->format( 'Y-m' ) . '%')
						    ->sum( 'amount' )
				    );
		    }
	    }

        $per_school_year = array();
        $school_years = SchoolYear::all();
	    if($one_school) {
		    foreach ( $school_years as $school_year ) {
			    $per_school_year[] =
				    array (
					    'school_year'        => $school_year->title,
					    'number_of_students' => Student::where( 'school_year_id', $school_year->id )
						                        ->where('school_id', session('current_school'))->count(),
					    'number_of_sections' => Section::where( 'school_year_id', $school_year->id )
						                        ->where('school_id', session('current_school'))->count()
				    );
		    }
	    }else{
		    foreach ( $school_years as $school_year ) {
			    $per_school_year[] =
				    array (
					    'school_year'        => $school_year->title,
					    'number_of_students' => Student::where( 'school_year_id', $school_year->id )->count(),
					    'number_of_sections' => Section::where( 'school_year_id', $school_year->id )->count()
				    );
		    }
	    }
        return array($per_month, $per_school_year, $teachers);
    }

}