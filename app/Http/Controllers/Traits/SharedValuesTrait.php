<?php

namespace App\Http\Controllers\Traits;

use DB;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Session;
use Laracasts\Flash\Flash;

trait SharedValuesTrait
{
    use SchoolYearTrait;

    public function shareValues()
    {
        if (isset($this->user->id)) {

            if ($this->user->inRole('super_admin')
                || $this->user->inRole('human_resources')
                || $this->user->inRole('accountant')
                || $this->user->inRole('librarian')
                || ($this->user->inRole('admin') && Settings::get('multi_school') == 'no')
            ) {
                /*
                * if current user is super admin , human resources or accountant
                */
                if ($this->user->inRole('super_admin')
                    || $this->user->inRole('human_resources')
                    || $this->user->inRole('accountant')
                    || ($this->user->inRole('admin') && Settings::get('multi_school') == 'no')
                ) {
                    $current_school = session('current_school');
                    if ($this->user->inRole('accountant') && Settings::get('account_one_school') == 'yes') {
                        $result = $this->currentSchoolAccountant($current_school, $this->user->id);
                    } else if($this->user->inRole('admin') && Settings::get('multi_school') == 'no') {
                        $result = $this->currentSchoolAdmin($current_school, $this->user->id);
                    }
                    else {
                        $result = $this->currentSchool($current_school);
                    }
                    if ((!isset($result['other_schools']) || count($result['other_schools']) == 0) &&
                        ($this->user->inRole('human_resources') || $this->user->inRole('accountant'))
                    ) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        if ($this->user->inRole('super_admin') &&
                            (!isset($result['other_schools']) || count($result['other_schools']) == 0)
                        ) {
                            Flash::error(trans('secure.create_school'));
                        }
                        else {
                            $this->setSessionSchool($result);
                        }
                    }
                }
                /*
                 * if current user is admin or human_resources or librarian
                 */
                if ($this->user->inRole('human_resources')
                    || $this->user->inRole('librarian')
                    || $this->user->inRole('accountant')
                    || ($this->user->inRole('admin') && Settings::get('multi_school') == 'no')
                ) {
                    $current_school_year = session('current_school_year');

                    $result = $this->currentSchoolYear($current_school_year);
                    if (!isset($result['other_school_years'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result);
                    }
                }
            }
            /*
             * if current user is admin
             */
            else if ($this->user->inRole('admin')) {

                $current_school_year = session('current_school_year');

                $result = $this->currentSchoolYear($current_school_year);
                if (!isset($result['other_school_years'])) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_school_year'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchoolYears($result);
                }

                $current_school = session('current_school');

                $result = $this->currentSchoolAdmin($current_school, $this->user->id);

                if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_schools'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchool($result);
                }
            }
            /*
             * if current user is teacher
             */
            else if ($this->user->inRole('teacher')) {

                    $current_school = session('current_school');

                    $result = $this->currentSchoolTeacher($current_school, $this->user->id);

                    if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchool($result);
                    }

                    $current_school_year = session('current_school_year');
                    $result = $this->currentSchoolYearTeacher($current_school_year, $this->user->id);
                    if (!isset($result['other_school_years']) || count($result['other_school_years']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result);
                    }
                    $student_group = session('current_student_group');
                    $current_school_year = session('current_school_year');

                    $result_groups = $this->currentTeacherStudentGroupSchool($student_group, $current_school_year, $current_school);
                    if (empty($result_groups['student_groups'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));
                        return redirect()->guest('/');
                    } else {
                        $this->setSessionTeacherStudentGroups($result_groups);
                    }
                }

                /*
                * if current user is parent
                */
                else if ($this->user->inRole('parent')) {
                    $current_school = session('current_school');

                    $result = $this->currentSchoolParent($current_school, $this->user->id);

                    if (!isset($result['other_schools']) || count($result['other_schools']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_schools'));

                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchool($result);
                    }

                    $current_school_year = session('current_school_year');
                    $student_id = session('current_student_id');
                    $current_school = session('current_school');

                    $result = $this->currentSchoolYearParent($current_school_year, $student_id, $current_school);
                    if (!isset($result['other_school_years']) || count($result['other_school_years']) == 0) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_school_year'));
                        return redirect()->guest('/');
                    } else {
                        $this->setSessionSchoolYears($result);
                    }

                    $current_school_year = session('current_school_year');
                    $student_id = session('current_student_id');

                    $result = $this->currentParentStudents($student_id, $current_school_year, $current_school);

                    if (!isset($result['student_ids'])) {
                        Sentinel::logout(null, true);
                        Session::flush();
                        Flash::error(trans('secure.no_students_added'));
                        return redirect()->guest('/');
                    } else {
                        $this->setStudentParent($result);
                    }
                }
            /*
             * if current user is student
             */
            else if ($this->user->inRole('student')) {

                $current_school = session('current_school');

                $result = $this->currentSchoolStudent($current_school, $this->user->id);

                if (!isset($result['other_schools'])) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_schools'));

                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchool($result);
                }
                $current_school_year = session('current_school_year');
                $result_school_year = $this->currentSchoolYearSchoolStudent($current_school_year, $this->user->id, session('current_school'));

                if (!isset($result_school_year['other_school_years']) || count($result_school_year['other_school_years']) == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_school_year'));
                    return redirect()->guest('/');
                } else {
                    $this->setSessionSchoolYears($result_school_year);
                }

                $student_section = session('current_student_section');
                $current_school_year = session('current_school_year');
                $result_section = $this->currentStudentSectionSchool($student_section, $current_school_year, session('current_school'));
                if (!isset($result_section['student_section_id']) || $result_section['student_section_id'] == 0) {
                    Sentinel::logout(null, true);
                    Session::flush();
                    Flash::error(trans('secure.no_sections_added'));
                    return redirect()->guest('/');
                } else {
                    $this->setSessionStudentSection($result_section);
                }
            }
        } else {
            return redirect('/signin');
        }
    }
}