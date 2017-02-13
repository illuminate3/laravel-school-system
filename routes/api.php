<?php
/******************   API routes  ******************************/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['version' => 'v1', 'prefix' => 'api','namespace' => 'App\Http\Controllers\Api'], function ($api) {

    $api->post('login', 'AuthController@login');

    $api->group(array('middleware' => 'jwt.auth'), function ($api) {

        //routes for all users
        $api->get('refresh', 'AuthController@refreshToken');
        $api->get('behaviors', 'GeneralController@behaviors');
        $api->get('directions', 'GeneralController@directions');
        $api->get('dormitories', 'GeneralController@dormitories');
        $api->get('dormitory_beds', 'GeneralController@dormitoryBeds');
        $api->get('dormitory_rooms', 'GeneralController@dormitoryRooms');
        $api->get('mark_types', 'GeneralController@markTypes');
        $api->get('mark_values', 'GeneralController@markValues');
        $api->get('notice_types', 'GeneralController@noticeTypes');
        $api->get('sections', 'GeneralController@sections');
        $api->get('semesters', 'GeneralController@semesters');
        $api->get('subjects', 'GeneralController@subjects');
        $api->post('reserve_book', 'GeneralController@reserveBook');
        $api->get('payments', 'GeneralController@payments');
        $api->get('student', 'GeneralController@student');
        $api->get('book_search', 'GeneralController@bookSearch');
        $api->get('user_search', 'GeneralController@userSearch');
        $api->get('reserved_user_books', 'GeneralController@reservedUserBooks');
        $api->get('borrowed_user_books', 'GeneralController@borrowedUserBooks');
        $api->get('subject_books', 'GeneralController@subjectBooks');
        $api->get('options_for_type', 'GeneralController@optionsForType');
        $api->get('transportations_directions', 'GeneralController@transportationsDirections');
        $api->get('borrowed_books', 'GeneralController@borrowedBooks');

        //routes for student and parent
        $api->group(array('prefix' => 'student_parent', ['middleware' => 'has_any_role:api.student,api.parent']), function ($api) {
            $api->get('timetable_day', 'StudentParentController@timetableDay');
            $api->get('subject_list', 'StudentParentController@subjectList');
            $api->get('attendances_date', 'StudentParentController@attendancesDate');
            $api->get('exams_date', 'StudentParentController@examsDate');
            $api->get('marks_date', 'StudentParentController@marksDate');
            $api->get('notices_date', 'StudentParentController@noticesDate');
            $api->get('diary_date', 'StudentParentController@diaryForDate');
        });

        //routes for student
        $api->group(array('prefix' => 'student', 'middleware' => 'api.student'), function ($api) {
            $api->get('school_year_student', 'StudentController@schoolYearStudent');
            $api->get('school_years_students', 'StudentController@schoolYearsStudents');
        });

        //routes for parent
        $api->group(array('prefix' => 'parent', 'middleware' => 'api.parent'), function ($api) {
            $api->get('school_year_student', 'ParentController@schoolYearStudent');
            $api->get('school_years_students', 'ParentController@schoolYearsStudents');
            $api->get('applying_leave', 'ParentController@applyingLeave');
            $api->post('post_applying_leave', 'ParentController@postApplyingLeave');
            $api->get('fee_details', 'ParentController@feeDetails');
            $api->get('schools', 'ParentController@schools');
        });

        //routes for teacher
        $api->group(array('prefix' => 'teacher', 'middleware' => 'api.teacher'), function ($api) {
            $api->get('school_year_group', 'TeacherController@selectSchoolYearGroup');
            $api->get('school_years', 'TeacherController@schoolYears');
            $api->get('timetable', 'TeacherController@timetable');
            $api->get('timetable_group', 'TeacherController@timetableGroup');
            $api->get('timetable_day', 'TeacherController@timetableDay');
            $api->get('timetable_group_day', 'TeacherController@timetableGroupDay');
            $api->get('subject_list', 'TeacherController@subjectList');
            $api->get('subject_list_group', 'TeacherController@subjectListGroup');
            $api->get('groups', 'TeacherController@groups');
            $api->get('notices', 'TeacherController@notices');
            $api->post('post_notice', 'TeacherController@postNotice');
            $api->post('edit_notice', 'TeacherController@editNotice');
            $api->post('delete_notice', 'TeacherController@deleteNotice');
            $api->get('exams', 'TeacherController@exams');
            $api->post('post_exam', 'TeacherController@postExam');
            $api->post('edit_exam', 'TeacherController@editExam');
            $api->post('delete_exam', 'TeacherController@deleteExam');
            $api->get('attendances', 'TeacherController@attendances');
            $api->get('attendances_date', 'TeacherController@attendancesDate');
            $api->get('attendance_hour_list', 'TeacherController@attendanceHourList');
            $api->post('post_attendance', 'TeacherController@postAttendance');
            $api->post('edit_attendance', 'TeacherController@editAttendance');
            $api->post('delete_attendance', 'TeacherController@deleteAttendance');
            $api->get('marks', 'TeacherController@marks');
            $api->get('marks_date', 'TeacherController@marksDate');
            $api->post('post_mark', 'TeacherController@postMark');
            $api->post('edit_mark', 'TeacherController@editMark');
            $api->post('delete_mark', 'TeacherController@deleteMark');
            $api->get('students', 'TeacherController@students');
            $api->get('diary', 'TeacherController@diary');
            $api->get('diary_date', 'TeacherController@diaryForDate');
            $api->post('post_diary', 'TeacherController@postDairy');
            $api->post('edit_diary', 'TeacherController@editDairy');
            $api->post('delete_diary', 'TeacherController@deleteDairy');
            $api->get('exam_marks', 'TeacherController@examMarks');
            $api->get('exam_marks_details', 'TeacherController@examMarksDetails');
            $api->get('applying_leave', 'TeacherController@applyingLeave');
            $api->get('subjects','TeacherController@subjects');
            $api->get('subject_exams','TeacherController@subjectExams');
            $api->get('hours','TeacherController@hours');
            $api->get('schools', 'TeacherController@schools');
        });

        //routes for librarian
        $api->group(array('prefix' => 'librarian', 'middleware' => 'api.librarian'), function ($api) {
            $api->post('edit_book', 'LibrarianController@editBook');
            $api->post('add_book', 'LibrarianController@addBook');
            $api->post('delete_book', 'LibrarianController@deleteBook');
            $api->get('reserved_books', 'LibrarianController@reservedBooks');
            $api->post('delete_reserved_book', 'LibrarianController@deleteReserveBook');
            $api->post('issue_reserved_book', 'LibrarianController@issueReservedBook');
            $api->post('issue_book', 'LibrarianController@issueBook');
            $api->post('return_book', 'LibrarianController@returnBook');
            $api->get('subject_list', 'LibrarianController@subjectList');
            $api->get('user_list', 'LibrarianController@userList');
        });

    });
    //routes for site part
    $api->group(array('prefix' => 'open', 'version' => 'v1'), function ($api) {
        $api->get('school_years', 'OpenController@schoolYears');
	    $api->get('schools', 'OpenController@schools');
        $api->get('semesters', 'OpenController@semesters');
        $api->get('sections', 'OpenController@sections');
	    $api->get('sections_all', 'OpenController@sectionsAll');
        $api->get('student_groups', 'OpenController@studentGroups');
        $api->get('student_group_marks', 'OpenController@studentGroupMarks');
	    $api->post('add_user', 'OpenController@addUser');
	    $api->post('edit_user', 'OpenController@editUser');
	    $api->post('delete_user', 'OpenController@deleteUser');
    });

    //routes for school admin
    $api->group(array('prefix' => 'admin', 'version' => 'v1'), function ($api) {
        $api->get('generate_token', 'AdminController@generateToken');
       // $api->group(array('middleware' => 'desktop.admin'), function ($api) {
            $api->get('roles', 'AdminController@getRoles');
            $api->get('teachers', 'AdminController@getTeachers');
            $api->post('edit_teachers', 'AdminController@editTeachers');
            $api->post('add_teachers', 'AdminController@addTeachers');
            $api->post('edit_teacher', 'AdminController@editTeacher');
            $api->post('add_teacher', 'AdminController@addTeacher');
            $api->post('delete_teacher', 'AdminController@deleteTeacher');

            $api->get('directions', 'AdminController@getDirections');
        //});
    });
});