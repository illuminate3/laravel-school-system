<?php

namespace App\Http\Controllers\Traits;

use App\Models\AccountantSchool;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\TeacherSubject;
use DB;
use Sentinel;
use Session;

trait SchoolYearTrait
{
    public function currentSchoolYear($current_school_year_id)
    {
        if (!isset($current_school_year_id) || $current_school_year_id == "") {
            $school_year = SchoolYear::orderBy('id', 'DESC')->first();
        } else {
            $school_year = SchoolYear::where('id', $current_school_year_id)->first();
            if (!isset($school_year->id)) {
                $school_year = SchoolYear::orderBy('id', 'DESC')->first();
            }
        }
        $value = isset($school_year) ? $school_year->title : "--";
        $id = isset($school_year) ? $school_year->id : 0;

        $school_years = SchoolYear::orderBy('id', 'DESC')->select(array('id', 'title'))->get();

        return array(
            'current_school_value' => $value,
            'current_school_id' => $id,
            'other_school_years' => $school_years,
        );
    }

    public function currentSchool($current_school_id)
    {
        if (!isset($current_school_id) || $current_school_id == "") {
            $school = School::where('schools.active', 1)
                ->orderBy('id', 'DESC')->first();
        } else {
            $school = School::where('schools.active', 1)
                ->where('id', $current_school_id)->first();
            if (!isset($school->id)) {
                $school = School::where('active', 1)->orderBy('id', 'DESC')->first();
            }
        }
        $value = isset($school) ? $school->title : "--";
        $id = isset($school) ? $school->id : 0;

        $schools = School::where('schools.active', 1)->orderBy('id', 'DESC')->select(array('id', 'title'))->get();

        return array(
            'current_school_item' => $value,
            'current_school' => $id,
            'other_schools' => $schools,
        );
    }

	public function currentSchoolAccountant($current_school_id, $user_id)
	{
		if (!isset($current_school_id) || $current_school_id == "") {
			$school = AccountantSchool::join('schools', 'schools.id', '=', 'accountant_schools.school_id')
			                     ->where('user_id', $user_id)
			                     ->where('schools.active', 1)
			                     ->orderBy('schools.id', 'DESC')
			                     ->select('schools.*')->first();
		} else {
			$school = AccountantSchool::join('schools', 'schools.id', '=', 'accountant_schools.school_id')
			                     ->where('schools.id', $current_school_id)
			                     ->where('schools.active', 1)
			                     ->where('user_id', $user_id)
			                     ->select('schools.*')->first();
			if (!isset($school->id)) {
				$school = AccountantSchool::join('schools', 'schools.id', '=', 'accountant_schools.school_id')
				                     ->where('user_id', $user_id)
				                     ->where('schools.active', 1)
				                     ->orderBy('schools.id', 'DESC')
				                     ->select('schools.*')->first();
			}
		}
		$value = isset($school) ? $school->title : "--";
		$id = isset($school) ? $school->id : 0;

		$schools = AccountantSchool::join('schools', 'schools.id', '=', 'accountant_schools.school_id')
		                      ->where('user_id', $user_id)
		                      ->where('schools.active', 1)
		                      ->orderBy('id', 'DESC')->select('schools.*')->get();

		return array(
			'current_school_item' => $value,
			'current_school' => $id,
			'other_schools' => $schools,
		);
	}

    public function currentSchoolAdmin($current_school_id, $user_id)
    {
        if (!isset($current_school_id) || $current_school_id == "") {
            $school = SchoolAdmin::join('schools', 'schools.id', '=', 'school_admins.school_id')
                ->where('user_id', $user_id)
                ->where('schools.active', 1)
                ->orderBy('schools.id', 'DESC')
                ->select('schools.*')->first();
        } else {
            $school = SchoolAdmin::join('schools', 'schools.id', '=', 'school_admins.school_id')
                ->where('schools.id', $current_school_id)
                ->where('schools.active', 1)
                ->where('user_id', $user_id)
                ->select('schools.*')->first();
            if (!isset($school->id)) {
                $school = SchoolAdmin::join('schools', 'schools.id', '=', 'school_admins.school_id')
                    ->where('user_id', $user_id)
                    ->where('schools.active', 1)
                    ->orderBy('schools.id', 'DESC')
                    ->select('schools.*')->first();
            }
        }
        $value = isset($school) ? $school->title : "--";
        $id = isset($school) ? $school->id : 0;

        $schools = SchoolAdmin::join('schools', 'schools.id', '=', 'school_admins.school_id')
            ->where('user_id', $user_id)
            ->where('schools.active', 1)
            ->orderBy('id', 'DESC')->select('schools.*')->get();

        return array(
            'current_school_item' => $value,
            'current_school' => $id,
            'other_schools' => $schools,
        );
    }

    public function currentSchoolYearTeacher($current_school_year_id, $user_id)
    {
        $school_year_org = SchoolYear::join('teacher_subjects', 'teacher_subjects.school_year_id', '=', 'school_years.id')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('teacher_subjects.teacher_id', $user_id)
            ->orderBy('school_years.id', 'DESC')
            ->select('school_years.*')
            ->distinct();
        if (!isset($current_school_year_id) || $current_school_year_id == "") {
            $school_year = $school_year_org->first();
        } else {
            $school_year = SchoolYear::where('id', $current_school_year_id)->first();
            if (!isset($school_year->id)) {
                $school_year = $school_year_org = SchoolYear::join('teacher_subjects', 'teacher_subjects.school_year_id', '=', 'school_years.id')
                    ->whereNull('teacher_subjects.deleted_at')
                    ->where('teacher_subjects.teacher_id', $user_id)
                    ->orderBy('school_years.id', 'DESC')
                    ->select('school_years.*')
                    ->distinct()->first();
            }
        }
        $value = isset($school_year) ? $school_year->title : "--";
        $id = isset($school_year) ? $school_year->id : 0;

        $school_years = SchoolYear::join('teacher_subjects', 'teacher_subjects.school_year_id', '=', 'school_years.id')
            ->whereNull('teacher_subjects.deleted_at')
            ->where('teacher_subjects.teacher_id', $user_id)
            ->orderBy('school_years.id', 'DESC')
            ->select('school_years.*')
            ->distinct()->get();

        return array(
            'current_school_value' => $value,
            'current_school_id' => $id,
            'other_school_years' => $school_years,
        );
    }

    public function currentSchoolTeacher($current_school_id, $user_id)
    {
        if (!isset($current_school_id) || $current_school_id == "") {
            $school = School::leftJoin('teacher_schools', 'schools.id', '=', 'teacher_schools.school_id')
                ->leftJoin('teacher_subjects', 'schools.id', '=', 'teacher_subjects.school_id')
                ->where('teacher_id', $user_id)
                ->orWhere('user_id', $user_id)
                ->where('schools.active', 1)
                ->orderBy('schools.id', 'DESC')
                ->select('schools.*')->distinct()->first();
        } else {
            $school = School::leftJoin('teacher_schools', 'schools.id', '=', 'teacher_schools.school_id')
                ->leftJoin('teacher_subjects', 'schools.id', '=', 'teacher_subjects.school_id')
                ->where('teacher_id', $user_id)
                ->orWhere('user_id', $user_id)
                ->where('schools.id', $current_school_id)
                ->where('schools.active', 1)
                ->select('schools.*')->distinct()->first();
            if (!isset($school->id)) {
                $school = School::leftJoin('teacher_schools', 'schools.id', '=', 'teacher_schools.school_id')
                    ->leftJoin('teacher_subjects', 'schools.id', '=', 'teacher_subjects.school_id')
                    ->where('teacher_id', $user_id)
                    ->orWhere('user_id', $user_id)
                    ->where('teacher_id', $user_id)
                    ->where('schools.active', 1)
                    ->orderBy('schools.id', 'DESC')
                    ->select('schools.*')->distinct()->first();
            }
        }
        $value = isset($school) ? $school->title : "--";
        $id = isset($school) ? $school->id : 0;

        $schools = $school = School::leftJoin('teacher_schools', 'schools.id', '=', 'teacher_schools.school_id')
            ->leftJoin('teacher_subjects', 'schools.id', '=', 'teacher_subjects.school_id')
            ->where('teacher_id', $user_id)
            ->orWhere('user_id', $user_id)
            ->where('schools.active', 1)
            ->orderBy('id', 'DESC')->distinct()->select('schools.*')->get();

        return array(
            'current_school_item' => $value,
            'current_school' => $id,
            'other_schools' => $schools,
        );
    }

    public function currentSchoolYearSchoolStudent($current_school_year_id, $user_id, $school_id)
    {
        $school_year_org = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->whereNull('students.deleted_at')
            ->where('students.user_id', $user_id)
            ->where('students.school_id', $school_id)
            ->orderBy('school_years.id', 'DESC')
            ->select('school_years.*')
            ->distinct()->first();
        if (!isset($current_school_year_id) || $current_school_year_id == "") {
            $school_year = $school_year_org;
        } else {
            $school_year = SchoolYear::where('id', $current_school_year_id)->first();
            if (!isset($school_year->id)) {
                $school_year = $school_year_org;
            }
        }
        $value = isset($school_year) ? $school_year->title : "--";
        $id = isset($school_year) ? $school_year->id : 0;

        $school_years = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->whereNull('students.deleted_at')
            ->where('students.user_id', $user_id)
            ->where('students.school_id', $school_id)
            ->orderBy('school_years.id', 'DESC')
            ->select('school_years.*')
            ->distinct()->get();

        return array(
            'current_school_value' => $value,
            'current_school_id' => $id,
            'other_school_years' => $school_years,
        );
    }

    public function currentSchoolStudent($current_school_id, $user_id)
    {
        if (!isset($current_school_id) || $current_school_id == "") {
            $school = School::join('sections', 'schools.id', '=', 'sections.school_id')
                ->join('students', 'students.section_id', '=', 'sections.id')
                ->where('user_id', $user_id)->orderBy('schools.id', 'DESC')
                ->select('schools.*')->distinct()->first();
        } else {
            $school = School::join('sections', 'schools.id', '=', 'sections.school_id')
                ->join('students', 'students.section_id', '=', 'sections.id')
                ->where('schools.id', $current_school_id)->where('user_id', $user_id)
                ->select('schools.*')->first();
            if (!isset($school->id)) {
                $school = School::join('sections', 'schools.id', '=', 'sections.school_id')
                    ->where('user_id', $user_id)->orderBy('schools.id', 'DESC')
                    ->select('schools.*')->distinct()->first();
            }
        }
        $value = isset($school) ? $school->title : "--";
        $id = isset($school) ? $school->id : 0;

        $schools = School::join('sections', 'schools.id', '=', 'sections.school_id')
            ->join('students', 'students.section_id', '=', 'sections.id')
            ->where('user_id', $user_id)->distinct()->orderBy('id', 'DESC')->select('schools.*')->get();

        return array(
            'current_school_item' => $value,
            'current_school' => $id,
            'other_schools' => $schools,
        );
    }

    public function semestersForSchoolYear($school_year)
    {
        $school_semesters = Semester::orderBy('start', 'DESC')
            ->where('school_year_id', $school_year)
            ->select(array('id', 'title', 'from', 'start', 'end'))->get();

        return array('school_semesters' => $school_semesters);
    }

    public function setSessionSchoolYears($result)
    {
        $value = $result['current_school_value'];
        $id = $result['current_school_id'];
        $school_years = $result['other_school_years'];

        session(['current_school_year' => $id]);

        view()->share('current_school_year', $value);
        view()->share('current_school_year_id', $id);
        view()->share('school_years', $school_years);
    }

    public function setSessionSchool($result)
    {
        $value = $result['current_school_item'];
        $id = $result['current_school'];
        $schools = $result['other_schools'];

        session(['current_school' => $id]);

        view()->share('current_school_item', $value);
        view()->share('current_school', $id);
        view()->share('schools', $schools);
    }

    public function currentTeacherStudentGroupSchool($student_group, $current_school_year, $current_school)
    {
        $teacher_groups = TeacherSubject::where('teacher_id', '=', $this->user->id)
            ->where('school_year_id', '=', $current_school_year)
            ->where('school_id', '=', $current_school)
            ->orderBy('id', 'DESC')
            ->whereNull('deleted_at')
            ->distinct()->pluck('student_group_id')->toArray();

        if (!isset($student_group) || $student_group == "") {

            $student_groups = StudentGroup::join('directions', 'directions.id', '=', 'student_groups.direction_id')
                ->whereNull('directions.deleted_at')
                ->whereIn('student_groups.id', $teacher_groups)
                ->orderBy('student_groups.id', 'DESC')
                ->select('student_groups.id', 'student_groups.title')->first();
        } else {
            $student_groups = StudentGroup::join('directions', 'directions.id', '=', 'student_groups.direction_id')
                ->whereNull('directions.deleted_at')
                ->whereIn('student_groups.id', $teacher_groups)
                ->where('student_groups.id', $student_group)
                ->select('student_groups.id', 'student_groups.title')->first();
            if (!isset($student_groups->id)) {

                $student_groups = StudentGroup::join('directions', 'directions.id', '=', 'student_groups.direction_id')
                    ->whereNull('directions.deleted_at')
                    ->whereIn('student_groups.id', $teacher_groups)
                    ->orderBy('student_groups.id', 'DESC')
                    ->select('student_groups.id', 'student_groups.title')->first();
            }
        }
        $student_group = isset($student_groups) ? $student_groups->title : "--";
        $student_group_id = isset($student_groups) ? $student_groups->id : 0;
        $student_groups = StudentGroup::join('directions', 'directions.id', '=', 'student_groups.direction_id')
            ->whereNull('directions.deleted_at')
            ->whereIn('student_groups.id', $teacher_groups)
            ->orderBy('student_groups.id', 'DESC')
            ->select('student_groups.id', 'student_groups.title')->get();

        return array(
            'current_student_group' => $student_group,
            'current_student_group_id' => $student_group_id,
            'student_groups' => $student_groups,
        );
    }

    public function setSessionTeacherStudentGroups($result)
    {
        $current_student_group = $result['current_student_group'];
        $current_student_group_id = $result['current_student_group_id'];
        $student_groups = $result['student_groups'];

        session(['current_student_group' => $current_student_group_id]);

        view()->share('current_student_group', $current_student_group);
        view()->share('current_student_group_id', $current_student_group_id);
        view()->share('student_groups', $student_groups);
    }

    public function currentStudentSectionSchool($student_section, $school_year_id, $school_id)
    {
        if (!isset($student_section) || $student_section == "") {
            $student_sections = Student::join('sections', 'sections.id', '=', 'students.section_id')
                ->where('students.user_id', '=', $this->user->id)
                ->where('students.school_year_id', $school_year_id)
                ->where('students.school_id', $school_id)
                ->whereNull('sections.deleted_at')
                ->orderBy('students.school_year_id', 'DESC')
                ->select('sections.id', 'students.id as student', 'sections.title')->first();
            if (!isset($student_sections->id)) {
                $student_sections = Student::join('sections', 'sections.id', '=', 'students.section_id')
                    ->where('students.user_id', '=', $this->user->id)
                    ->whereNull('sections.deleted_at')
                    ->orderBy('students.school_year_id', 'DESC')
                    ->select('sections.id', 'students.id as student', 'sections.title')->first();
            }
        } else {
            $student_sections = Student::join('sections', 'sections.id', '=', 'students.section_id')
                ->where('students.user_id', '=', $this->user->id)
                ->where('students.school_year_id', $school_year_id)
                ->where('students.school_id', $school_id)
                ->whereNull('sections.deleted_at')
                ->where('sections.id', $student_section)
                ->orderBy('students.school_year_id', 'DESC')
                ->select('sections.id', 'students.id as student', 'sections.title')->first();
            if (!isset($student_sections->id)) {
                $student_sections = Student::join('sections', 'sections.id', '=', 'students.section_id')
                    ->where('students.user_id', '=', $this->user->id)
                    ->where('students.school_year_id', $school_year_id)
                    ->where('students.school_id', $school_id)
                    ->orderBy('students.school_year_id', 'DESC')
                    ->select('sections.id', 'students.id as student', 'sections.title')->first();
            }
        }
        $student_section = isset($student_sections) ? $student_sections->title : "--";
        $student_section_id = isset($student_sections) ? $student_sections->id : 0;

        return array(
            'student_section' => $student_section,
            'student_section_id' => $student_section_id,
        );
    }

    public function setSessionStudentSection($result)
    {
        $student_section = $result['student_section'];
        $student_section_id = $result['student_section_id'];

        session(['current_student_section' => $student_section_id]);

        view()->share('current_student_section', $student_section);
        view()->share('current_student_section_id', $student_section_id);
    }

    public function currentParentStudents($student_id, $current_school_year, $school_id)
    {
        if (!isset($student_id) || $student_id == "") {
            $student_ids = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
                ->whereNull('students.deleted_at');
            if ($current_school_year > 0) {
                $student_ids = $student_ids->where('students.school_year_id', $current_school_year);
            }
            $student_ids = $student_ids->where('parent_students.user_id_parent', $this->user->id)
                ->where('students.school_id', $school_id)
                ->orderBy('students.id', 'DESC')
                ->distinct()
                ->select('students.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))
                ->first();
        } else {
            $student_ids = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
                ->whereNull('students.deleted_at');
            if ($current_school_year > 0) {
                $student_ids = $student_ids->where('students.school_year_id', $current_school_year);
            }
            $student_ids = $student_ids->where('parent_students.user_id_parent', $this->user->id)
                ->where('students.school_id', $school_id)
                ->where('students.id', $student_id)
                ->orderBy('students.id', 'DESC')
                ->distinct()
                ->select('students.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))
                ->first();

            if (!isset($student_ids->id)) {
                $student_ids = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
                    ->join('users', 'users.id', '=', 'students.user_id')
                    ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
                    ->whereNull('students.deleted_at');
                if ($current_school_year > 0) {
                    $student_ids = $student_ids->where('students.school_year_id', $current_school_year);
                }
                $student_ids = $student_ids->where('parent_students.user_id_parent', $this->user->id)
                    ->where('students.school_id', $school_id)
                    ->orderBy('students.id', 'DESC')
                    ->distinct()
                    ->select('students.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))
                    ->get();
            }
        }
        $student_name = isset($student_ids) ? $student_ids->name : "--";
        $student_id = isset($student_ids) ? $student_ids->id : 0;

        $student_ids = Student::join('users', 'users.id', '=', 'students.user_id')
            ->join('parent_students', 'users.id', '=', 'parent_students.user_id_student')
            ->orderBy('students.school_year_id', 'DESC')
            ->where('parent_students.user_id_parent', '=', $this->user->id)
            ->where('students.school_year_id', $current_school_year)
            ->where('students.school_id', $school_id)
            ->distinct()
            ->select('students.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))
            ->get();
        return array(
            'current_student_name' => $student_name,
            'current_student_id' => $student_id,
            'student_ids' => $student_ids,
        );
    }

    public function setStudentParent($result)
    {
        $student_name = $result['current_student_name'];
        $student_id = $result['current_student_id'];
        $student_ids = $result['student_ids'];

        session(['current_student_id' => $student_id]);

        $student = Student::find($student_id);
        session(['current_student_user_id' => isset($student) ? $student->user_id : 0]);

        view()->share('current_student_name', $student_name);
        view()->share('current_student_id', $student_id);
        view()->share('student_ids', $student_ids);
    }

    public function currentSchoolYearParent($current_school_year_id, $student_id, $school_id)
    {
        if (!isset($current_school_year_id) || $current_school_year_id == "") {
            $school_year = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
                ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
                ->whereNull('students.deleted_at');
            if ($student_id > 0) {
                $school_year = $school_year->where('students.id', $student_id);
            }
            $school_year = $school_year->where('parent_students.user_id_parent', $this->user->id)
                ->where('students.school_id', $school_id)
                ->orderBy('school_years.id', 'DESC')
                ->select('school_years.*')
                ->distinct()->first();
        } else {
            $school_year = SchoolYear::where('id', $current_school_year_id)->first();
            if (!isset($school_year->id)) {
                $school_year = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
                    ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
                    ->whereNull('students.deleted_at');
                if ($student_id > 0) {
                    $school_year = $school_year->where('students.id', $student_id);
                }
                $school_year = $school_year->where('parent_students.user_id_parent', $this->user->id)
                    ->where('students.school_id', $school_id)
                    ->orderBy('school_years.id', 'DESC')
                    ->select('school_years.*')
                    ->distinct()->first();
            }
        }
        $value = isset($school_year) ? $school_year->title : "--";
        $id = isset($school_year) ? $school_year->id : 0;

        $school_years = SchoolYear::join('students', 'students.school_year_id', '=', 'school_years.id')
            ->join('parent_students', 'parent_students.user_id_student', '=', 'students.user_id')
            ->whereNull('students.deleted_at')
            ->where('parent_students.user_id_parent', $this->user->id)
            ->where('students.school_id', $school_id)
            ->orderBy('school_years.id', 'DESC')
            ->distinct()
            ->select('school_years.*')->get();

        return array(
            'current_school_value' => $value,
            'current_school_id' => $id,
            'other_school_years' => $school_years,
        );
    }

    public function currentSchoolParent($current_school_id, $user_id)
    {
        if (!isset($current_school_id) || $current_school_id == "") {
            $school = School::join('students', 'students.school_id', '=', 'schools.id')
                ->join('parent_students', 'students.user_id', '=', 'parent_students.user_id_student')
                ->where('parent_students.user_id_parent', $user_id)->orderBy('schools.id', 'DESC')
                ->select('schools.*')->distinct()->first();
        } else {
            $school = School::join('students', 'students.school_id', '=', 'schools.id')
                ->join('parent_students', 'students.user_id', '=', 'parent_students.user_id_student')
                ->where('parent_students.user_id_parent', $user_id)
                ->where('schools.id', $current_school_id)
                ->select('schools.*')->distinct()->first();
            if (!isset($school->id)) {
                $school = School::join('students', 'students.school_id', '=', 'schools.id')
                    ->join('parent_students', 'students.user_id', '=', 'parent_students.user_id_student')
                    ->where('parent_students.user_id_parent', $user_id)->orderBy('schools.id', 'DESC')
                    ->select('schools.*')->distinct()->first();
            }
        }
        $value = isset($school) ? $school->title : "--";
        $id = isset($school) ? $school->id : 0;

        $schools = School::join('students', 'students.school_id', '=', 'schools.id')
            ->join('parent_students', 'students.user_id', '=', 'parent_students.user_id_student')
            ->where('parent_students.user_id_parent', $user_id)->orderBy('schools.id', 'DESC')
            ->select('schools.*')->distinct()->get();

        return array(
            'current_school_item' => $value,
            'current_school' => $id,
            'other_schools' => $schools,
        );
    }
}