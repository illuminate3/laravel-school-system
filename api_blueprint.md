FORMAT: 1A

# API_SMS

# Auth
Authentication related endpoints

## Login to system [POST /login]


+ Request (application/json)
    + Body

            {
                "email": "foo",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "token": "token",
                "user": {
                    "id": 4,
                    "first_name": "Teacher",
                    "last_name": "Doe",
                    "email": "teacher@sms.com",
                    "last_login": "2015-09-07 19:27:08",
                    "address": "Address",
                    "picture": "image.jpg",
                    "mobile": "+545154515",
                    "phone": "+545154515",
                    "gender": 0,
                    "birth_date": "2015-06-02",
                    "birth_city": "Banja Luka"
                },
                "role": "teacher"
            }

+ Response 401 (application/json)
    + Body

            {
                "error": "invalid_credentials"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "could_not_create_token"
            }

## Refresh token [GET /refresh]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "token": "token"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "could_not_create_token"
            }

# General
General endpoints which can be accessed by any user group

## Behaviors [GET /behaviors]
Get all behaviors
This list use teacher to put behavior to student

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "behaviors": [
                    {
                        "id": "1",
                        "title": "Good"
                    },
                    {
                        "id": "2",
                        "title": "Worse"
                    }
                ]
            }

## Directions [GET /directions]
Get all directions
This is list of all directions of school mostly is for admin who create groups of students

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "directions": [
                    {
                        "id": "1",
                        "title": "Sociology",
                        "duration": "3"
                    },
                    {
                        "id": "2",
                        "title": "History",
                        "duration": "4"
                    }
                ]
            }

## Dormitories [GET /dormitories]
Get all dormitories
Method for admin to list all dormitories in school

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            [
                {
                    "id": "1",
                    "title": "Student hotel 1"
                },
                {
                    "id": "2",
                    "title": "Student hotel 2"
                }
            ]

## Dormitory rooms [GET /dormitory_rooms]
Get all dormitory rooms
Method for admin to list all dormitory rooms in school

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "dormitories": [
                    {
                        "id": "1",
                        "dormitory": "Student hotel 1",
                        "title": "Room 1"
                    },
                    {
                        "id": "2",
                        "dormitory": "Student hotel 2",
                        "title": "Room 1"
                    }
                ]
            }

## Dormitory beds [GET /dormitory_beds]
Get all dormitory beds
Method for admin to list all dormitory beds and know which student is in which room in school

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "dormitories": [
                    {
                        "id": 1,
                        "dormitory": "Flat 1",
                        "dormitory_room": "sdffdsfdsfsdf",
                        "student": "Student2 User",
                        "dormitory_bed": "dfdfgdfgfd"
                    }
                ]
            }

## Mark types [GET /mark_types]
Get all mark types
Teachers need this to choose which is mark type

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "mark_type": [
                    {
                        "id": "1",
                        "title": "Oral"
                    },
                    {
                        "id": "2",
                        "title": "Writing"
                    }
                ]
            }

## Mark values [GET /mark_values]
Get all mark values for selected subject
Teachers need this to choose which is mark value

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "subject_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "mark_values": [
                    {
                        "id": "1",
                        "title": "A"
                    },
                    {
                        "id": "2",
                        "title": "B"
                    }
                ]
            }

## Notice types [GET /notice_types]
Get all notice types
Teachers need this to choose which is notice type

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "notice_type": [
                    {
                        "id": "1",
                        "title": "Notice of oral"
                    },
                    {
                        "id": "2",
                        "title": "Notice of writing test"
                    }
                ]
            }

## Reserve book [POST /reserve_book]
Reserve book from user, all role can reseve book

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "book_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Payments for user [GET /payments]
Get all payments for user, student select there payment and parent select for there students sending user_id of that student

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "payments": [
                    {
                        "id": 1,
                        "amount": "10.5",
                        "title": "This is title of payment",
                        "description": "This is description of payment",
                        "created_at": "2015-06-05 10:55:11"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get student for user and school year, parent use it for there students [GET /student]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_id": "1",
                "school_year_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "student": [
                    {
                        "student_id": "1",
                        "section_id": "1",
                        "section_name": "1-2",
                        "order": "2"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get search books [GET /book_search]


+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "search": "Test book"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "id": "1",
                        "subject": "History",
                        "subject_id": 3,
                        "title": "History of world 1",
                        "author": "Group of authors",
                        "year": "2015",
                        "internal": "2015/15",
                        "publisher": "Book publisher",
                        "version": "0.2",
                        "issued": 2,
                        "quantity": 2
                    },
                    {
                        "id": "2",
                        "subject": "English",
                        "subject_id": 1,
                        "title": "English 2",
                        "author": "Group of authors",
                        "year": "2015",
                        "internal": "2015/15",
                        "publisher": "Book publisher",
                        "version": "0.2",
                        "issued": 1,
                        "quantity": 2
                    }
                ]
            }

## Get search users [GET /user_search]


+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "search": "Test user"
            }

+ Response 200 (application/json)
    + Body

            {
                "users": [
                    {
                        "id": "1",
                        "name": "Name Surname"
                    }
                ]
            }

## Reserved books for user [GET /reserved_user_books]
Get all reserved books for user

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_id": 5
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "id": "1",
                        "title": "Book for mathematics",
                        "author": "Group of authors",
                        "subject": "Mathematics",
                        "reserved": "2015-08-10"
                    }
                ]
            }

## Borrowed books for user [GET /borrowed_user_books]
Get all borrowed books for user

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_id": 5
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "id": 12,
                        "title": "EngLib",
                        "author": "Ruth D. Brown",
                        "subject": "English",
                        "internal": "12-15",
                        "get": "2015-09-11"
                    },
                    {
                        "id": 13,
                        "title": "SciLib",
                        "author": "Matthew D. Stewart",
                        "subject": "Science",
                        "internal": "158/59",
                        "get": "2015-09-11"
                    }
                ],
                "user": {
                    "id": 15,
                    "name": "Full Name",
                    "email": "address@sms.com",
                    "address": "Kincheloe Road Portland",
                    "mobile": "345376587657",
                    "phone": "",
                    "gender": 1
                }
            }

## Books for subject [GET /subject_books]
Get all books for subject

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "subject_id": "5"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "id": "1",
                        "title": "Book for mathematics",
                        "author": "Group of authors",
                        "year": "2015",
                        "internal": "15-14",
                        "publisher": "Book publisher",
                        "version": "0.2",
                        "quantity": 2,
                        "issued": 1
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get options for type [GET /options_for_type]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "category": "attendance_type|exam_type"
            }

+ Response 200 (application/json)
    + Body

            {
                "options": [
                    {
                        "id": "1",
                        "category": "exam_type",
                        "title": "Oral exam",
                        "value": "Oral exam"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get transportations and directions [GET /transportations_directions]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "transport": [
                    {
                        "id": "1",
                        "title": "Oral exam",
                        "start": "12:50",
                        "end": "15:15",
                        "locations": [
                            {
                                "id": 10,
                                "name": "Location 1",
                                "lat": 0.124,
                                "lang": 0.124
                            }
                        ]
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Borrowed books [GET /borrowed_books]
Get all borrowed books

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "title": "Book for mathematics",
                        "id": "12",
                        "internal": "12-45",
                        "author": "Group of authors",
                        "get": "2015-08-10"
                    }
                ]
            }

# Student [/student_parent]
Student adn parent endpoints, can be accessed only with role "student" or "parent"

## Get timetable classes for student for selected school year and day (day: 1-Monday,. [GET /student_parent/timetable_day]
.. 7-Sunday)

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "day_id": "1",
                "student_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "timetable": {
                    "1": {
                        "id": 10,
                        "subject": "English",
                        "teacher": "Test teacher 1"
                    },
                    "2": {
                        "id": 11,
                        "subject": "Serbian",
                        "teacher": "Test teacher 2"
                    }
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## List of subjects and teachers for student [GET /student_parent/subject_list]
Get list of subjects and teachers for student

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "subject_list": {
                    "id": 4,
                    "subject": "history",
                    "teacher": "Teacher 1"
                },
                "0": {
                    "id": 1,
                    "subject": "english",
                    "teacher": "Teacher 2"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all attendances for student for date [GET /student_parent/attendances_date]


+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2015-10-12"
            }

+ Response 200 (application/json)
    + Body

            {
                "attendance": [
                    {
                        "id": 1,
                        "subject": "English",
                        "hour": "2",
                        "option": "Present",
                        "option_id": "1",
                        "date": "2015-10-19"
                    }
                ]
            }

## Exams for teacher group [GET /student_parent/exams_date]
Get all exams for teacher group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2016-08-22"
            }

+ Response 200 (application/json)
    + Body

            {
                "exams": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "description": "This is description of exam",
                        "subject": "English"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all marks for student for selected date [GET /student_parent/marks_date]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2015-10-22"
            }

+ Response 200 (application/json)
    + Body

            {
                "marks": [
                    {
                        "id": 1,
                        "subject": "Subject Name",
                        "mark_type": "Oral",
                        "mark_value": "A+",
                        "exam": "Exam 1",
                        "date": "2015-10-22"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all notices for student and date [GET /student_parent/notices_date]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2015-10-22"
            }

+ Response 200 (application/json)
    + Body

            {
                "notice": [
                    {
                        "id": 1,
                        "title": "This is title of notice",
                        "subject": "English",
                        "description": "This is description of notice"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all diaries for student and selected date [GET /student_parent/diary_date]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2015-10-10"
            }

+ Response 200 (application/json)
    + Body

            {
                "diaries": [
                    {
                        "id": 1,
                        "title": "This is title of notice",
                        "subject": "English",
                        "description": "This is description of notice",
                        "hour": "2",
                        "date": "2015-02-02"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

# Student [/student]
Student endpoints, can be accessed only with role "student"

## Get last school year and student_id for student user [GET /student/school_year_student]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "school_year_id": 1,
                "school_year": "2015-2016",
                "student_id": "1"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get school years and student_id for student user [GET /student/school_years_student]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "other_school_years": {
                    "school_year_id": 1,
                    "school_year": "2015-2016",
                    "student_id": "1"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

# Parent [/parent]
Parent endpoints, can be accessed only with role "parent"

## Get last school year and student_id for student user [GET /parent/school_year_student]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "school_year_id": 1,
                "school_year": "2015-2016",
                "student_id": "1",
                "student_first_name": "Student",
                "student_last_name": "User"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get school years and student_id for student user [GET /parent/school_years_student]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "other_school_years": {
                    "school_year_id": 1,
                    "school_year": "2015-2016",
                    "student_id": "1",
                    "student_first_name": "Student",
                    "student_last_name": "User"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all applying leave for selected student [GET /parent/applying_leave]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "applying_leave": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "description": "This is description of exam",
                        "date": "2015-02-02"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post applying leave for student [POST /parent/post_applying_leave]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "title": "This is title",
                "date": "2015-06-20",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all fee details leave for selected student
(paid=1-payed , 0-not payed) [GET /parent/fee_details]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "fee_details": {
                    "student_name": "Student  Name",
                    "terms": [
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
                    ],
                    "total_fee": "400.00",
                    "paid_fee": "300.00",
                    "balance_fee": "100.00"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

# Teacher [/teacher]
Teacher endpoints, can be accessed only with role "teacher"

## Schools for teacher [GET /teacher/schools]
Get all schools for selected user

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_id": 1
            }

+ Response 200 (application/json)
    + Body

            {
                "current_school_item": "First school",
                "current_school": 1,
                "other_schools": {
                    "id": 1,
                    "title": "Primary school"
                }
            }

## School year for user [GET /teacher/school_years]
Get all school years with current school year name and id and other school years that he/she can select.
This method use all roles because all data(students, sections, marks, behaviors,semesters,attendances) are depend on school year

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_year_id": 1
            }

+ Response 200 (application/json)
    + Body

            {
                "current_school_value": "2014/2015",
                "current_school_id": 1,
                "other_school_years": {
                    "id": 1,
                    "title": "2014/2015"
                }
            }

## Timetable for teacher [GET /teacher/timetable]
Get timetable for teacher with getting his token and role teacher
This method return array of array: first array has number of hour, first subarray is array for number of day and
in that array have objects that represent subject and teacher that teaches.
After first array goes second array that represents subjects and group that teacher teach in
selected school year.

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_year_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "timetable": {
                    "1": {
                        "1": {
                            "id": 10,
                            "subject": "english",
                            "group": "1 - 2"
                        },
                        "2": {
                            "id": 11,
                            "subject": "serbian",
                            "group": "2 - 2"
                        }
                    },
                    "2": {
                        "1": {
                            "id": 12,
                            "subject": "history",
                            "group": "1 - 3"
                        },
                        "2": {
                            "id": 13,
                            "subject": "english",
                            "group": "1 - 2"
                        }
                    }
                },
                "subject_group": [
                    {
                        "id": 4,
                        "subject": "history",
                        "group": "1 - 3"
                    },
                    {
                        "id": 1,
                        "subject": "english",
                        "group": "1 - 3"
                    }
                ]
            }

## Timetable for teacher for selected group [GET /teacher/timetable_group]
Get timetable for teacher with getting selected group id
This method return array of array: first array has number of hour, first subarray is array for number of day and
in that array have objects that represent subject and teacher that teaches.
After first array goes second array that represents subjects and group that teacher teach in
selected group.

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "timetable": {
                    "1": {
                        "1": {
                            "id": 10,
                            "subject": "english",
                            "group": "1 - 2"
                        },
                        "2": {
                            "id": 11,
                            "subject": "serbian",
                            "group": "2 - 2"
                        }
                    },
                    "2": {
                        "1": {
                            "id": 12,
                            "subject": "history",
                            "group": "1 - 3"
                        },
                        "2": {
                            "id": 13,
                            "subject": "english",
                            "group": "1 - 2"
                        }
                    }
                },
                "subject_group": [
                    {
                        "id": 4,
                        "subject": "history",
                        "group": "1 - 3"
                    },
                    {
                        "id": 1,
                        "subject": "english",
                        "group": "1 - 3"
                    }
                ]
            }

## Timetable classes for teacher for selected day and school year [GET /teacher/timetable_day]
Get timetable classes for teacher for selected day and school year.(1-Monday,... 7-Sunday)

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_year_id": "1",
                "day_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "timetable": {
                    "1": {
                        "id": 10,
                        "subject": "english",
                        "group": "1 - 2"
                    },
                    "2": {
                        "id": 11,
                        "subject": "serbian",
                        "group": "2 - 2"
                    }
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Timetable for teacher for selected group, day and school year [GET /teacher/timetable_group_day]
Get timetable classes for teacher for selected group, day and school year.(day: 1-Monday,... 7-Sunday)

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "day_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "timetable": {
                    "1": {
                        "id": 10,
                        "subject": "english",
                        "group": "1 - 2"
                    },
                    "2": {
                        "id": 11,
                        "subject": "serbian",
                        "group": "2 - 2"
                    }
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Subject list for teacher for school year [GET /teacher/subject_list]
Get subject list for teacher for school year

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_year_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "subject_list": {
                    "id": 4,
                    "subject": "history",
                    "group": "1 - 3"
                },
                "0": {
                    "id": 1,
                    "subject": "english",
                    "group": "1 - 3"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Subject list for teacher for student group [GET /teacher/subject_list_group]
Get subject list for teacher for student group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "subject_list": {
                    "id": 4,
                    "subject": "history",
                    "group": "1 - 3"
                },
                "0": {
                    "id": 1,
                    "subject": "english",
                    "group": "1 - 3"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Groups for teacher [GET /teacher/groups]
Get all groups for teacher for selected school year

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "school_year_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "student_groups": [
                    {
                        "id": 1,
                        "title": "Group 1",
                        "direction": "English",
                        "class": 2
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Notices for teacher group [GET /teacher/notices]
Get all notices for teacher group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "school_year_id": "1",
                "school_id": "1",
                "date": "2015-10-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "notice": [
                    {
                        "id": 1,
                        "title": "This is title of notice",
                        "notice_type_id": "1",
                        "subject_id": "1",
                        "subject": "English",
                        "notice_type": "Exam",
                        "description": "This is description of notice",
                        "date": "2015-10-15"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post notice for teacher group [POST /teacher/post_notice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "school_year_id": "1",
                "school_id": "1",
                "notice_type_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-06-18",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit notice [POST /teacher/edit_notice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "notice_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-06-15",
                "notice_type_id": "1",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete notice [POST /teacher/delete_notice]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "notice_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Exams for teacher group [GET /teacher/exams]
Get all exams for teacher group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "exams": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "subject": "English",
                        "subject_id": "1",
                        "date": "2015-10-15",
                        "description": "This is a description"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post exam for teacher group [POST /teacher/post_exam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-08-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit exam [POST /teacher/edit_exam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "exam_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-08-15",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete exam [POST /teacher/delete_exam]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "exam_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Attendances for teacher group between two date [GET /teacher/attendances]
Get all attendances for teacher group between two date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "start_date": "2015-15-12",
                "end_date": "2015-08-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "attendance": [
                    {
                        "id": 1,
                        "student": "Student Name",
                        "hour": "2",
                        "option": "Late",
                        "date": "2015-08-15"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Attendances for teacher group by date [GET /teacher/attendances_date]
Get all attendances for teacher group by date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-19"
            }

+ Response 200 (application/json)
    + Body

            {
                "attendance": [
                    {
                        "id": 1,
                        "student": "Student Name",
                        "student_id": "1",
                        "hour": "2",
                        "option": "Present",
                        "option_id": "1",
                        "date": "2015-10-19"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Attendances list of hours from timetable [GET /teacher/attendance_hour_list]
Get all attendances list of hours from timetable for selected date and group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-19"
            }

+ Response 200 (application/json)
    + Body

            {
                "hour_list": [
                    {
                        "id": 1,
                        "hour": "1",
                        "subject_id": "1",
                        "subject": "english"
                    },
                    {
                        "id": 2,
                        "hour": "2",
                        "subject_id": "1",
                        "subject": "history"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post attendance for student,subject and date [POST /teacher/post_attendance]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_id": "1",
                "date": "2015-06-13",
                "hour": "2",
                "student_group_id": "1",
                "option_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit attendance [POST /teacher/edit_attendance]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "attendance_id": "1",
                "date": "2015-06-13",
                "hour": "1",
                "student_id": "1",
                "option_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete attendance [POST /teacher/delete_attendance]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "attendance_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Marks for teacher group between two date [GET /teacher/marks]
Get all marks for teacher group between two date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "subject_id": "1",
                "start_date": "2015-12-15",
                "end_date": "2015-12-19"
            }

+ Response 200 (application/json)
    + Body

            {
                "marks": [
                    {
                        "id": 1,
                        "student_name": "Student Name",
                        "student_id": "1",
                        "mark_type": "Oral",
                        "mark_type_id": "1",
                        "mark_value": "A+",
                        "mark_value_id": "1",
                        "exam": "Exam 1",
                        "exam_id": "1",
                        "date": "2016-12-16"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Marks for teacher group for selected date [GET /teacher/marks_date]
Get all marks for teacher group for selected date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-16"
            }

+ Response 200 (application/json)
    + Body

            {
                "marks": [
                    {
                        "id": 1,
                        "student_name": "Student Name",
                        "student_id": "1",
                        "subject": "Subject",
                        "subject_id": "1",
                        "mark_type": "Oral",
                        "mark_type_id": "1",
                        "mark_value": "A+",
                        "mark_value_id": "1",
                        "exam": "Exam 1",
                        "exam_id": "1",
                        "date": "2016-10-16"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post mark for student,subject and date [POST /teacher/post_mark]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "exam_id": "1",
                "mark_type_id": "1",
                "student_id": 1,
                "subject_id": "1",
                "mark_value_id": "1",
                "date": "2015-10-15",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit mark [POST /teacher/edit_mark]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "mark_id": "1",
                "date": "2015-08-15",
                "exam_id": "1",
                "student_id": "1",
                "mark_type_id": "1",
                "subject_id": "1",
                "mark_value_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete mark [POST /teacher/delete_mark]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "mark_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Students for teacher group [GET /teacher/students]
Get all students for teacher group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "students": [
                    {
                        "id": 1,
                        "student_name": "Student Name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Borrowed books [GET /teacher/borrowed_books]
Get all borrowed books

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "user_book_id": "1",
                        "title": "Book for mathematics",
                        "author": "Group of authors",
                        "get": "2015-08-10"
                    }
                ]
            }

## Dairies for student [GET /teacher/diary]
Get all diaries for student

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "diaries": [
                    {
                        "id": 1,
                        "title": "This is title of diary",
                        "subject": "English",
                        "description": "This is description of diary",
                        "hour": "2",
                        "date": "2015-02-15"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Dairies for student group and date [GET /teacher/diary_date]
Get all diaries for student group and selected date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "diaries": [
                    {
                        "id": 1,
                        "title": "This is title of diary",
                        "subject_id": 12,
                        "subject": "English",
                        "description": "This is description of diary",
                        "hour": "2",
                        "date": "2015-10-15"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post diary for subject, hour and date [POST /teacher/post_diary]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-06-15",
                "hour": "1",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit diary [POST /teacher/edit_diary]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "diary_id": "1",
                "subject_id": "1",
                "title": "This is title",
                "date": "2015-06-15",
                "hour": "1",
                "description": "This is description"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete diary [POST /teacher/delete_diary]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "diary_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get exams with totals marks [GET /teacher/exam_marks]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "exams": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "subject": "English",
                        "date": "2015-02-15",
                        "total_marks": "5"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get exams for subject [GET /teacher/subject_exams]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "subject_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "exams": [
                    {
                        "id": 1,
                        "title": "English",
                        "date": "2015-10-15"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get marks for selected exam [GET /teacher/exam_marks_details]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "exam_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "marks": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "description": "This is description of exam",
                        "subject": "English",
                        "date": "2015-02-15",
                        "marks": [
                            {
                                "id": "105",
                                "mark_value": "F",
                                "mark_type": "gk"
                            }
                        ]
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all applying leave for selected student [GET /teacher/applying_leave]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "applying_leave": [
                    {
                        "id": 1,
                        "title": "This is title of exam",
                        "description": "This is description of exam",
                        "date": "2015-10-15",
                        "student_name": "Student Name"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get last school year and group
Get last school year and group where teacher teach some subject [GET /teacher/school_year_group]


+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "school_year_id": 1,
                "school_year": "2015-2016",
                "school_id": 1,
                "school": "School",
                "group_id": "1",
                "group": "1-2"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Subject for subject [GET /teacher/subjects]
Get all subject for teacher for selected student group

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "subjects": [
                    {
                        "id": 1,
                        "title": "English"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Hours for group and date [GET /teacher/hours]
Get all hours for selected student group and date

+ Request (application/json)
    + Body

            {
                "token": "foo",
                "student_group_id": "1",
                "date": "2015-10-15",
                "subject_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "hours": [
                    {
                        "id": "1",
                        "hour": "2"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

# Librarian [/librarian]
Librarian endpoints, can be accessed only with role "librarian"

## Borrowed books [GET /librarian/borrowed_books]
Get all borrowed books

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": [
                    {
                        "user_book_id": "1",
                        "title": "Book for mathematics",
                        "author": "Group of authors",
                        "get": "2015-08-10"
                    }
                ]
            }

## Post new book [POST /librarian/add_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "subject_id": "1",
                "title": "Title of book",
                "author": "This is author",
                "year": "2015",
                "quantity": "5",
                "internal": "2015/15",
                "publisher": "Book publisher 2",
                "version": "0.1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Delete book [POST /librarian/delete_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "book_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit book [POST /librarian/edit_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "book_id": "1",
                "subject_id": "1",
                "title": "Title of book",
                "author": "This is author",
                "year": "2015",
                "quantity": "5",
                "internal": "2015/15",
                "publisher": "Book publisher 2",
                "version": "0.1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Reserved books [GET /librarian/reserved_books]
Get all reserved books

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "books": {
                    "id": "1",
                    "title": "Book for mathematics",
                    "author": "Group of authors",
                    "subject": "Mathematics",
                    "reserved": "2015-08-10"
                }
            }

## Delete reserve book [POST /librarian/delete_reserved_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_book_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Issue reserved book [POST /librarian/issue_reserved_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_book_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Issue book [POST /librarian/issue_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "book_id": "1",
                "user_id": "1",
                "note": "This is note",
                "date": "2015-02-02"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Return ook [POST /librarian/return_book]


+ Request (application/json)
    + Body

            {
                "token": "foo",
                "user_book_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success"
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get list of subjects [GET /librarian/subject_list]
Get list of subjects for all directions and class use for creating book

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "subjects": [
                    {
                        "id": "1",
                        "title": "Direction2 (3) English",
                        "direction": "Direction2",
                        "class": "3",
                        "subject": "English"
                    }
                ]
            }

## Get list of users [GET /librarian/user_list]
Get list of users for issuing book

+ Request (application/json)
    + Body

            {
                "token": "foo"
            }

+ Response 200 (application/json)
    + Body

            {
                "users": [
                    {
                        "id": "1",
                        "name": "First Last name",
                        "role": "teacher|librarian|admin|student|parent"
                    }
                ]
            }

# Open [/open]
Open endpoints, can be accessed only without any role, it's public data

## Get all school years [GET /open/school_years]


+ Response 200 (application/json)
    + Body

            {
                "school_years": [
                    {
                        "id": 1,
                        "title": "2015/2016"
                    }
                ]
            }

## Get all schools [GET /open/schools]


+ Response 200 (application/json)
    + Body

            {
                "schools": [
                    {
                        "id": 1,
                        "title": "School Name"
                    }
                ]
            }

## Get all semesters [GET /open/semesters]


+ Request (application/json)
    + Body

            {
                "school_year_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "semesters": [
                    {
                        "id": 1,
                        "title": "1st Term",
                        "start": "2016-01-19",
                        "end": "2016-05-19"
                    }
                ]
            }

## Get all sections [GET /open/sections]


+ Request (application/json)
    + Body

            {
                "school_year_id": "1",
                "school_id": "2"
            }

+ Response 200 (application/json)
    + Body

            {
                "sections": [
                    {
                        "id": 1,
                        "title": "1st Section"
                    }
                ]
            }

## Get all sections for all schools and school years [GET /open/sections_all]


+ Response 200 (application/json)
    + Body

            {
                "sections": [
                    {
                        "id": 1,
                        "title": "1st Section",
                        "school_year_id": 1,
                        "school_id": 1,
                        "school": "School name",
                        "school_year": "2015-2016"
                    }
                ]
            }

## Get all student groups [GET /open/student_groups]


+ Request (application/json)
    + Body

            {
                "section_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "student_groups": [
                    {
                        "id": 1,
                        "title": "1st Group"
                    }
                ]
            }

## Get all student marks in selected group [GET /open/student_group_marks]


+ Request (application/json)
    + Body

            {
                "student_group_id": "2",
                "school_year_id": "1",
                "semester_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "marks": [
                    {
                        "mark_type": "oral",
                        "mark_value": "A",
                        "subject": "English",
                        "exam": "Exam 1",
                        "date": "2016-06-06",
                        "student_first_name": "Name",
                        "student_last_name": "Last Name"
                    }
                ]
            }

# Admin [/admin]
Admin endpoints, can be accessed only with Desktop applications

## Generate token [GET /admin/generate_token]


+ Request (application/json)
    + Body

            {
                "auth_id": "foo",
                "auth_secure": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "token": "token"
            }

## Get all roles [GET /admin/roles]


+ Response 200 (application/json)
    + Body

            {
                "roles": [
                    {
                        "id": 1,
                        "slug": "teacher",
                        "name": "Teacher"
                    },
                    {
                        "id": 2,
                        "slug": "student",
                        "name": "Student"
                    }
                ]
            }

## Get all teachers [GET /admin/teachers]


+ Request (application/json)
    + Body

            {
                "school_id": "1",
                "page": "2",
                "limit": "10"
            }

+ Response 200 (application/json)
    + Body

            {
                "teachers": [
                    {
                        "web_id": 10,
                        "email": "teacher@sms.com",
                        "first_name": "Teacher",
                        "last_name": "User",
                        "address": "address",
                        "mobile": "54545",
                        "phone": null,
                        "gender": 0,
                        "birth_date": "2016-24-05",
                        "birth_city": "City",
                        "school_id": 1
                    }
                ],
                "total_pages": "15"
            }

## Post new teachers [POST /admin/add_teachers]


+ Request (application/json)
    + Body

            {
                "email": [
                    "teacher@sms.com",
                    "teache125r@sms.com"
                ],
                "password": [
                    "125125",
                    "124563"
                ],
                "first_name": [
                    "Teacher 22",
                    "Teacher 28"
                ],
                "last_name": [
                    "last_name 154",
                    "last_name 757"
                ],
                "address": [
                    "address 1",
                    "address 15"
                ],
                "mobile": [
                    "2154512",
                    "7854545"
                ],
                "birth_city": [
                    "City",
                    "City"
                ],
                "school_id": [
                    "1",
                    "1"
                ],
                "id": [
                    "5",
                    "10"
                ]
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success",
                "return_array": [
                    {
                        "web_id": 10,
                        "email": "email1@sms.com",
                        "id": "5"
                    },
                    {
                        "web_id": 11,
                        "email": "email2@sms.com",
                        "id": "6"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit teachers [POST /admin/edit_teachers]


+ Request (application/json)
    + Body

            {
                "email": [
                    "teacher@sms.com",
                    "teache125r@sms.com"
                ],
                "password": [
                    "125125",
                    "124563"
                ],
                "first_name": [
                    "Teacher 22",
                    "Teacher 28"
                ],
                "last_name": [
                    "last_name 154",
                    "last_name 757"
                ],
                "address": [
                    "address 1",
                    "address 15"
                ],
                "mobile": [
                    "2154512",
                    "7854545"
                ],
                "birth_city": [
                    "City",
                    "City"
                ],
                "school_id": [
                    "1",
                    "1"
                ],
                "id": [
                    "5",
                    "10"
                ],
                "web_id": [
                    "1",
                    "2"
                ],
                "deleted_at": [
                    "",
                    "2016-05-10 10:11:00"
                ]
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success",
                "return_array": [
                    {
                        "web_id": 10,
                        "email": "email1@sms.com",
                        "id": "5"
                    },
                    {
                        "web_id": 11,
                        "email": "email2@sms.com",
                        "id": "6"
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Post new teacher [POST /admin/add_teacher]


+ Request (application/json)
    + Body

            {
                "email": "email@email.com",
                "password": "pas$w0rd",
                "first_name": "Name",
                "last_name": "Surname",
                "address": "Address",
                "mobile": "54545",
                "birth_city": "City",
                "school_id": 1,
                "id": 1
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success",
                "return_array": {
                    "web_id": 5,
                    "email": "email@email.com",
                    "id": 1
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Edit teacher [POST /admin/edit_teacher]


+ Request (application/json)
    + Body

            {
                "web_id": "1",
                "email": "email@email.com",
                "password": "pas$w0rd",
                "first_name": "Name",
                "last_name": "Surname",
                "address": "Address",
                "mobile": "54545",
                "birth_city": "City",
                "school_id": 1,
                "id": "5",
                "deleted_at": "2016-05-10 10:11:00"
            }

+ Response 200 (application/json)
    + Body

            {
                "success": "success",
                "return_array": {
                    "web_id": 1,
                    "email": "email@email.com",
                    "id": "5"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "not_valid_data"
            }

## Get all directions for school [GET /admin/directions]


+ Request (application/json)
    + Body

            {
                "school_id": "1"
            }

+ Response 200 (application/json)
    + Body

            {
                "directions": [
                    {
                        "web_id": 10,
                        "title": "Direction 1",
                        "duration": "2"
                    }
                ]
            }