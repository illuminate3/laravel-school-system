<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use DB;

/**
 * Student endpoints, can be accessed only with role "student"
 *
 * @Resource("Student", uri="/student")
 */
class StudentController extends Controller
{
    use Helpers;

    /**
     * Get last school year and student_id for student user
     *
     * @Get("/school_year_student")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo"}),
     *      @Response(200, body={ "school_year_id": 1,
    "school_year": "2015-2016",
    "student_id": "1"
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    function schoolYearStudent(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $school_year_group = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->whereNull('students.deleted_at')
            ->where('users.id', $user->id)
            ->orderBy('school_years.id', 'DESC')
            ->orderBy('students.id', 'DESC')
            ->select('school_years.id as school_year_id', 'students.id as student_id',
                'school_years.title as school_year')
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
    "student_id": "1"}
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
            ->whereNull('students.deleted_at')
            ->where('users.id', $user->id)
            ->orderBy('school_years.id', 'DESC')
            ->orderBy('students.id', 'DESC')
            ->select('school_years.id as school_year_id', 'students.id as student_id',
                'school_years.title as school_year')
            ->distinct()->get();

        return response()->json(['other_school_years' => $school_year_group], 200);
    }
}
