<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\StudentGroup;
use Sentinel;
use Illuminate\Http\Request;
use Validator;

/**
 * Open endpoints, can be accessed only without any role, it's public data
 *
 * @Resource("Open", uri="/open")
 */
class OpenController extends Controller
{

    /**
     *
     * Get all school years
     *
     * @Get("/school_years")
     * @Versions({"v1"})
     * @Response(200, body={
				    "school_years": {
					    {"id":1,
					    "title":"2015/2016"}
				    }}
    )
     */
    public function schoolYears()
    {
        $school_years = SchoolYear::select('id', 'title')
            ->get()->toArray();
        return response()->json(compact('school_years'), 200);
    }

	/**
	 *
	 * Get all schools
	 *
	 * @Get("/schools")
	 * @Versions({"v1"})
	 * @Response(200, body={
		"schools": {
			{"id":1,
				"title":"School Name"}
			}}
		)
	 */
	public function schools()
	{
		$schools = School::select('id', 'title')
		                          ->get()->toArray();
		return response()->json(compact('schools'), 200);
	}

    /**
     *
     * Get all semesters
     *
     * @Get("/semesters")
     * @Versions({"v1"})
     * @Request({"school_year_id":"1"}),
     * @Response(200, body={
    "semesters": {
    {"id":1,
    "title":"1st Term",
    "start":"2016-01-19",
    "end":"2016-05-19"}}
    }
    )
     */
    public function semesters(Request $request)
    {
        $rules = array(
            'school_year_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $semesters = Semester::select('id', 'title', 'start', 'end')
                ->get()->toArray();
            return response()->json(compact('semesters'), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     *
     * Get all sections
     *
     * @Get("/sections")
     * @Versions({"v1"})
     * @Request({"school_year_id":"1","school_id":"2"}),
     * @Response(200, body={
				    "sections": {
							    {"id":1,
							    "title":"1st Section"}
				    }
                }
        )
     */
    public function sections(Request $request)
    {
        $rules = array(
            'school_year_id' => 'required|integer',
            'school_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $sections = Section::select('id', 'title')
                ->where('school_year_id', $request->input('school_year_id'))
                ->where('school_id', $request->input('school_id'))
                ->get()->toArray();
            return response()->json(compact('sections'), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

	/**
	 *
	 * Get all sections for all schools and school years
	 *
	 * @Get("/sections_all")
	 * @Versions({"v1"})
	 * @Response(200, body={
					"sections": {
							{"id":1,
							"title":"1st Section",
							"school_year_id":1,
							"school_id":1,
							"school":"School name",
							"school_year":"2015-2016"}
						}
					}
	)
	 */
	public function sectionsAll()
	{
		$sections = Section::join('schools', 'schools.id', '=', 'sections.school_id')
			->join('school_years', 'school_years.id', '=', 'sections.school_year_id')
			->select('sections.id', 'sections.title', 'sections.school_year_id', 'sections.school_id'
				, 'schools.title as school', 'school_years.title as school_year')
		                   ->get()->toArray();
		return response()->json(compact('sections'), 200);
	}


    /**
     *
     * Get all student groups
     *
     * @Get("/student_groups")
     * @Versions({"v1"})
     * @Request({"section_id":"1"}),
     * @Response(200, body={
				    "student_groups": {
						    {"id":1,
						    "title":"1st Group"}}
					}
                )
     */
    public function studentGroups(Request $request)
    {
        $rules = array(
            'section_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $student_groups = StudentGroup::select('id', 'title')
                ->where('section_id', $request->input('section_id'))
                ->get()->toArray();
            return response()->json(compact('student_groups'), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     *
     * Get all student marks in selected group
     *
     * @Get("/student_group_marks")
     * @Versions({"v1"})
     * @Request({"student_group_id":"2","school_year_id":"1","semester_id":"1"}),
     * @Response(200, body={
					    "marks": {
						    {"mark_type":"oral",
						    "mark_value":"A",
						    "subject":"English",
						    "exam":"Exam 1",
						    "date":"2016-06-06",
						    "student_first_name":"Name",
						    "student_last_name":"Last Name"}
                       }
          }
       )
     */
    public function studentGroupMarks(Request $request)
    {
        $rules = array(
            'student_group_id' => 'required|integer',
            'school_year_id' => 'required|integer',
            'semester_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $marks = Mark::join('mark_types', 'marks.mark_type_id', '=', 'mark_types.id')
                ->join('mark_values', 'marks.mark_value_id', '=', 'mark_values.id')
                ->join('students', 'students.id', '=', 'marks.student_id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('subjects', 'marks.subject_id', '=', 'subjects.id')
                ->join('student_student_group', 'student_student_group.student_id', '=', 'students.id')
                ->leftJoin('exams', 'exams.id', '=', 'marks.exam_id')
                ->where('student_student_group.student_group_id', $request->input('student_group_id'))
                ->where('marks.school_year_id', $request->input('school_year_id'))
                ->where('marks.semester_id', $request->input('semester_id'))
                ->select('mark_types.title as mark_type', 'mark_values.title as mark_value',
                    'subjects.title as subject', 'exams.title as exam', 'marks.date',
                    'users.first_name as student_first_name', 'users.last_name as student_last_name')
                ->distinct()
                ->get()->toArray();
            return response()->json(compact('marks'), 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }
}
