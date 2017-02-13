<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolYearTrait;
use App\Models\ApplyingLeave;
use App\Models\Invoice;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use DB;

/**
 * Parent endpoints, can be accessed only with role "parent"
 *
 * @Resource("Parent", uri="/parent")
 */
class ParentController extends Controller
{
    use Helpers;
    use SchoolYearTrait;

    /**
     * Get last school year and student_id for student user
     *
     * @Get("/school_year_student")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo"}),
     *      @Response(200, body={ "school_year_id": 1,
    "school_year": "2015-2016",
    "student_id": "1",
    "student_first_name": "Student",
    "student_last_name": "User"
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    function schoolYearStudent(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $school_year_group = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->whereNull('students.deleted_at')
            ->where('parent_students.user_id_parent', $user->id)
            ->orderBy('school_years.id', 'DESC')
            ->orderBy('students.id', 'DESC')
            ->select('school_years.id as school_year_id', 'students.id as student_id', 'first_name as student_first_name',
                'last_name as student_last_name', 'school_years.title as school_year')
            ->distinct()->first();

        return response()->json($school_year_group, 200);
    }

    /**
     * Get school years and student_id for student user
     *
     * @Get("/school_years_student")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo"}),
     *      @Response(200, body={ "other_school_years" : {
    "school_year_id": 1,
    "school_year": "2015-2016",
    "student_id": "1",
    "student_first_name": "Student",
    "student_last_name": "User"}
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    function schoolYearsStudents(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $school_year_group = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
            ->whereNull('students.deleted_at')
            ->where('parent_students.user_id_parent', $user->id)
            ->orderBy('school_years.id', 'DESC')
            ->orderBy('students.id', 'DESC')
            ->select('school_years.id as school_year_id', 'students.id as student_id', 'first_name as student_first_name',
                'last_name as student_last_name', 'school_years.title as school_year')
            ->distinct()->get();

        return response()->json(['other_school_years' => $school_year_group], 200);
    }

    /**
     * Get all applying leave for selected student
     *
     * @Get("/applying_leave")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1"}),
     *      @Response(200, body={
    "applying_leave": {
    {
    "id": 1,
    "title": "This is title of exam",
    "description": "This is description of exam",
    "date": "2015-02-02"
    }
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function applyingLeave(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = JWTAuth::parseToken()->authenticate();
            $applying_leave = ApplyingLeave::join('parent_students', 'parent_students.user_id_parent', '=', 'applying_leaves.parent_id')
                ->where('applying_leaves.parent_id', '=', $user->id)
                ->where('parent_students.activate', '=', 1)
                ->where('applying_leaves.student_id', '=', $request->input('student_id'))
                ->orderBy('applying_leaves.date', 'DESC')
                ->select(array('applying_leaves.id', 'applying_leaves.title', 'applying_leaves.date', 'applying_leaves.description'))
                ->get()->toArray();
            return response()->json(['applying_leave' => $applying_leave], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Post applying leave for student
     *
     * @Post("/post_applying_leave")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1","title":"This is title", "date":"2015-06-20","description":"This is description"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function postApplyingLeave(Request $request)
    {
        $rules = array(
            'student_id' => 'integer',
            'title' => 'required',
            'date' => 'required',
            'description' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $request->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format(Settings::get('date_format'));

            $student = Student::find($request->input('student_id'));
            $user = JWTAuth::parseToken()->authenticate();

            $applying_leave = new ApplyingLeave($request->except('token', 'date'));
            $applying_leave->parent_id = $user->id;
            $applying_leave->school_year_id = $student->school_year_id;
            $applying_leave->date = $request->date;
            $applying_leave->save();

            return response()->json(['success' => 'success'], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get all fee details leave for selected student
     * (paid=1-payed , 0-not payed)
     *
     * @Get("/fee_details")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "student_id":"1"}),
     *      @Response(200, body={
    "fee_details": {
    "student_name": "Student  Name",
    "terms": {
    {
    "id": "5",
    "title": "fee",
    "paid": "1",
    "amount": "200.00",
    "date": "2015-09-11 06:25:49"
    },
    {
    "id": "6",
    "title": "John Mid-Term",
    "paid": "0",
    "amount": "200.00",
    "date": "2015-09-16 10:03:20"
    }
    },
    "total_fee": "400.00",
    "paid_fee": "300.00",
    "balance_fee": "100.00"
    }
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function feeDetails(Request $request)
    {
        $rules = array(
            'student_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $fee_details = array();
            $student_id = $request->input('student_id');
            $user = User::find(Student::find($student_id)->user_id);
            $fee_details['student_name'] = $user->first_name . ' ' . $user->last_name;
            $fee_details['terms'] = Invoice::where('user_id', '=', $user->id)->count();
            $total_fee = Invoice::where('user_id', '=', $user->id)->sum('amount');
            $paid_fee = Invoice::where('user_id', '=', $user->id)->where('paid', '1')->sum('amount');
            $fee_details['total_fee'] = $total_fee;
            $fee_details['paid_fee'] = $paid_fee;
            $fee_details['terms'] = Invoice::leftJoin("payments", "payments.invoice_id", "=", 'invoices.id')
                ->where('invoices.user_id', '=', $user->id)
                ->select('invoices.id', 'invoices.title', 'invoices.paid', 'invoices.amount', 'payments.created_at as date')->get()->toArray();
            $fee_details['balance_fee'] = $total_fee - $paid_fee;
            return response()->json(['fee_details' => $fee_details], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }
}
