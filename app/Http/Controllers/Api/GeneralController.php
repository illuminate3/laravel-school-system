<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Option;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Transportation;
use App\Models\TransportationLocation;
use App\Models\User;
use App\Repositories\BehaviorRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\DormitoryBedRepository;
use App\Repositories\DormitoryRepository;
use App\Repositories\DormitoryRoomRepository;
use App\Repositories\MarkTypeRepository;
use App\Repositories\MarkValueRepository;
use App\Repositories\NoticeTypeRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use DB;

/**
 * General endpoints which can be accessed by any user group
 *
 * @Resource("General", uri="/")
 */
class GeneralController extends Controller
{
    use Helpers;

    /**
     * @var BehaviorRepository
     */
    private $behaviorRepository;
    /**
     * @var DirectionRepository
     */
    private $directionRepository;
    /**
     * @var DormitoryRepository
     */
    private $dormitoryRepository;
    /**
     * @var DormitoryBedRepository
     */
    private $dormitoryBedRepository;
    /**
     * @var DormitoryRoomRepository
     */
    private $dormitoryRoomRepository;
    /**
     * @var MarkTypeRepository
     */
    private $markTypeRepository;
    /**
     * @var MarkValueRepository
     */
    private $markValueRepository;
    /**
     * @var NoticeTypeRepository
     */
    private $noticeTypeRepository;

    public function __construct(BehaviorRepository $behaviorRepository,
                                DirectionRepository $directionRepository,
                                DormitoryRepository $dormitoryRepository,
                                DormitoryBedRepository $dormitoryBedRepository,
                                DormitoryRoomRepository $dormitoryRoomRepository,
                                MarkTypeRepository $markTypeRepository,
                                MarkValueRepository $markValueRepository,
                                NoticeTypeRepository $noticeTypeRepository)
    {
        $this->behaviorRepository = $behaviorRepository;
        $this->directionRepository = $directionRepository;
        $this->dormitoryRepository = $dormitoryRepository;
        $this->dormitoryBedRepository = $dormitoryBedRepository;
        $this->dormitoryRoomRepository = $dormitoryRoomRepository;
        $this->markTypeRepository = $markTypeRepository;
        $this->markValueRepository = $markValueRepository;
        $this->noticeTypeRepository = $noticeTypeRepository;
    }

    /**
     * Behaviors
     *
     * Get all behaviors
     * This list use teacher to put behavior to student
     *
     * @Get("/behaviors")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "behaviors":{
    {"id": "1",
    "title": "Good"},
    {"id": "2",
    "title": "Worse"}
    }
    })
     */
    public function behaviors()
    {
        $behaviors = $this->behaviorRepository->getAll()
            ->get()
            ->map(function ($behavior) {
                return [
                    'id' => $behavior->id,
                    'title' => $behavior->title
                ];
            })->toArray();
        return response()->json(['behaviors' => $behaviors], 200);
    }

    /**
     * Directions
     *
     * Get all directions
     * This is list of all directions of school mostly is for admin who create groups of students
     *
     * @Get("/directions")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "directions":{{"id": "1",
    "title": "Sociology",
    "duration": "3"},
    {"id": "2",
    "title": "History",
    "duration": "4"}
    }
    })
     */
    public function directions()
    {
        $directions = $this->directionRepository->getAll()
            ->get()
            ->map(function ($direction) {
                return [
                    'id' => $direction->id,
                    'title' => $direction->title,
                    'duration' => $direction->duration
                ];
            })->toArray();
        return response()->json(['directions' => $directions], 200);
    }

    /**
     * Dormitories
     *
     * Get all dormitories
     * Method for admin to list all dormitories in school
     *
     * @Get("/dormitories")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    {"id": "1",
    "title": "Student hotel 1"},
    {"id": "2",
    "title": "Student hotel 2"},
    })
     */
    public function dormitories()
    {
        $dormitories = $this->dormitoryRepository->getAll()
            ->get()
            ->map(function ($dormitory) {
                return [
                    'id' => $dormitory->id,
                    'title' => $dormitory->title
                ];
            })->toArray();
        return response()->json(['dormitories' => $dormitories], 200);
    }


    /**
     * Dormitory rooms
     *
     * Get all dormitory rooms
     * Method for admin to list all dormitory rooms in school
     *
     * @Get("/dormitory_rooms")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "dormitories":{{"id": "1",
    "dormitory": "Student hotel 1",
    "title": "Room 1"},
    {"id": "2",
    "dormitory": "Student hotel 2",
    "title": "Room 1"}
    }
    })
     */
    public function dormitoryRooms()
    {
        $dormitory_rooms = $this->dormitoryRoomRepository->getAll()
            ->with('dormitory')
            ->get()
            ->map(function ($dormitory) {
                return [
                    'id' => $dormitory->id,
                    'dormitory' => isset($dormitory->dormitory->title) ? $dormitory->dormitory->title : "",
                    'title' => $dormitory->title
                ];
            })->toArray();
        return response()->json(['dormitory_rooms' => $dormitory_rooms], 200);
    }

    /**
     * Dormitory beds
     *
     * Get all dormitory beds
     * Method for admin to list all dormitory beds and know which student is in which room in school
     *
     * @Get("/dormitory_beds")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "dormitories":{{
    "id": 1,
    "dormitory": "Flat 1",
    "dormitory_room": "sdffdsfdsfsdf",
    "student": "Student2 User",
    "dormitory_bed": "dfdfgdfgfd"
    }}
    })
     */
    public function dormitoryBeds()
    {
        $dormitory_beds = $this->dormitoryBedRepository->getAll()
            ->with('student', 'dormitory_room', 'dormitory_room.dormitory')
            ->get()
            ->map(function ($dormitory) {
                return [
                    'id' => $dormitory->id,
                    'dormitory' => isset($dormitory->dormitory_room->dormitory->title) ? $dormitory->dormitory_room->dormitory->title : "",
                    'dormitory_room' => isset($dormitory->dormitory_room->title) ? $dormitory->dormitory_room->title : "",
                    'student' => isset($dormitory->student->user->full_name) ? $dormitory->student->user->full_name : "",
                    'dormitory_bed' => $dormitory->title
                ];
            })->toArray();
        return response()->json(['dormitory_beds' => $dormitory_beds], 200);
    }

    /**
     * Mark types
     *
     * Get all mark types
     * Teachers need this to choose which is mark type
     *
     * @Get("/mark_types")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "mark_type":{{"id": "1",
    "title": "Oral"},
    {"id": "2",
    "title": "Writing"}}
    })
     */
    public function markTypes()
    {
        $mark_types = $this->markTypeRepository->getAll()
            ->get()
            ->map(function ($mark_type) {
                return [
                    'id' => $mark_type->id,
                    'title' => $mark_type->title
                ];
            })->toArray();
        return response()->json(['mark_type' => $mark_types], 200);
    }

    /**
     * Mark values
     *
     * Get all mark values for selected subject
     * Teachers need this to choose which is mark value
     *
     * @Get("/mark_values")
     * @Versions({"v1"})
     * @Request({"token": "foo","subject_id":"1"})
     * @Response(200, body={
    "mark_values":{{"id": "1",
    "title": "A"},
    {"id": "2",
    "title": "B"}}
    })
     */
    public function markValues(Request $request)
    {
        $rules = array(
            'subject_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $mark_values = $this->markValueRepository->getAllForSubject($request['subject_id'])
                ->get()
                ->map(function ($mark_value) {
                    return [
                        'id' => $mark_value->id,
                        'title' => $mark_value->title,
                    ];
                })->toArray();
            return response()->json(['mark_values' => $mark_values], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Notice types
     *
     * Get all notice types
     * Teachers need this to choose which is notice type
     *
     * @Get("/notice_types")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "notice_type": {
    {"id": "1",
    "title": "Notice of oral"},
    {"id": "2",
    "title": "Notice of writing test"}
    }
    })
     */
    public function noticeTypes()
    {
        $notice_types = $this->noticeTypeRepository->getAll()
            ->get()
            ->map(function ($notice_type) {
                return [
                    'id' => $notice_type->id,
                    'title' => $notice_type->title
                ];
            })->toArray();
        return response()->json(['notice_type' => $notice_types], 200);
    }

    /**
     * Reserve book
     *
     * Reserve book from user, all role can reseve book
     *
     * @Post("/reserve_book")
     * @Versions({"v1"})
    @Transaction({
     * @Request({"token": "foo", "book_id": "1"}),
     * @Response(200, body={"success":"success"}),
     * @Response(500, body={"error":"not_valid_data"})
     * })
     * })
     */
    public function reserveBook(Request $request)
    {
        $rules = array(
            'book_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = JWTAuth::parseToken()->authenticate();
            $book_user = new BookUser();
            $book_user->book_id = $request->input('book_id');
            $book_user->user_id = $user->id;
            $book_user->reserved = date('Y-m-d');
            $book_user->save();
            return response()->json(["success" => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Payments for user
     *
     * Get all payments for user, student select there payment and parent select for there students sending user_id of that student
     *
     * @Get("/payments")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "user_id":"1"}),
     *      @Response(200, body={
    "payments": {{
    "id": 1,
    "amount": "10.5",
    "title": "This is title of payment",
    "description": "This is description of payment",
    "created_at": "2015-06-05 10:55:11"
    }}
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function payments(Request $request)
    {
        $rules = array(
            'user_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $payments = Payment::where('user_id', $request->input('user_id'))
                ->oderBy('id', 'DESC')
                ->select(array('id', 'amount', 'title', 'description', 'created_at'));
            return response()->json(['payments' => $payments], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get student for user and school year, parent use it for there students
     *
     * @Get("/student")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "user_id":"1", "school_year_id":"1"}),
     *      @Response(200, body={
    "student":{{
    "student_id": "1",
    "section_id": "1",
    "section_name": "1-2",
    "order": "2"
    }}
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function student(Request $request)
    {
        $rules = array(
            'user_id' => 'required|integer',
            'school_year_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $student = Student::join('sections', 'sections.id', '=', 'students.section_id')
                ->where('user_id', $request->input('user_id'))
                ->where('school_year_id', $request->input('school_year_id'))
                ->select(array('students.id as student_id', 'students.section_id', 'students.title as section_name', 'students.order'));
            return response()->json(['student' => $student], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }


    /**
     * Get search books
     *
     * @Get("/book_search")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "search":"Test book"}),
     *      @Response(200, body={
    "books": {
    {"id": "1",
    "subject": "History",
    "subject_id":3,
    "title": "History of world 1",
    "author": "Group of authors",
    "year": "2015",
    "internal": "2015/15",
    "publisher": "Book publisher",
    "version": "0.2",
    "issued": 2,
    "quantity": 2},
    {"id": "2",
    "subject": "English",
    "subject_id":1,
    "title": "English 2",
    "author": "Group of authors",
    "year": "2015",
    "internal": "2015/15",
    "publisher": "Book publisher",
    "version": "0.2",
    "issued": 1,
    "quantity": 2}
    }
    })
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function bookSearch(Request $request)
    {
        $rules = array(
            'search' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $books = Book::leftJoin('subjects', 'subjects.id', '=', 'books.subject_id')
                ->where(function ($query) use ($request) {
                    return $query->where('books.title', 'LIKE', "%" . $request->input('search') . "%")
                        ->orWhere('books.author', 'LIKE', "%" . $request->input('search') . "%")
                        ->orWhere('books.year', 'LIKE', "%" . $request->input('search') . "%")
                        ->orWhere('books.internal', 'LIKE', "%" . $request->input('search') . "%")
                        ->orWhere('books.publisher', 'LIKE', "%" . $request->input('search') . "%");
                })
                ->select(array('books.id', 'subjects.id as subject_id', 'subjects.title as subject', 'books.title', 'books.author', 'books.year'
                , 'books.internal', 'books.publisher', 'books.version', 'books.quantity',
                    DB::raw('(SELECT count(id) FROM book_users as bu
                                WHERE bu.id= books.id AND bu.back IS NULL AND bu.get IS NOT NULL) as issued')
                ))
                ->get()->toArray();
            return response()->json(['books' => $books], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get search users
     *
     * @Get("/user_search")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "search":"Test user"}),
     *      @Response(200, body={
    "users":{{"id": "1",
    "name": "Name Surname"}}
    })
    }),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function userSearch(Request $request)
    {
        $rules = array(
            'search' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $search = explode(' ', $request->input('search'));
            $users = User::where('first_name', 'LIKE', "%$search[0]%")
                ->orWhere('first_name', 'LIKE', "%$search[1]%")
                ->orWhere('last_name', 'LIKE', "%$search[0]%")
                ->orWhere('last_name', 'LIKE', "%$search[1]%")
                ->select(array('users.id', DB::raw('CONCAT(users.first_name, " ", users.last_name) as name')))->get()->toArray();
            return response()->json(['users' => $users], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Reserved books for user
     *
     * Get all reserved books for user
     *
     * @Get("/reserved_user_books")
     * @Versions({"v1"})
     * @Request({"token": "foo", "user_id":5})
     * @Response(200, body={
    "books":{
    {"id": "1",
    "title": "Book for mathematics",
    "author": "Group of authors",
    "subject": "Mathematics",
    "reserved": "2015-08-10"}
    }
    })
     */
    public function reservedUserBooks(Request $request)
    {
        $rules = array(
            'user_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $books = BookUser::join('books', 'books.id', '=', 'book_users.book_id')
                ->whereNotNull('reserved')
                ->whereNull('get')
                ->whereNull('books.deleted_at')
                ->where('book_users.user_id', $request->input('user_id'))
                ->select(array('book_users.id', 'books.internal', 'books.title', 'books.author',
                    DB::raw('(SELECT title from subjects where subjects.id=books.subject_id) as subject'),
                    'book_users.reserved'))->get()->toArray();
            return response()->json(['books' => $books], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Borrowed books for user
     *
     * Get all borrowed books for user
     *
     * @Get("/borrowed_user_books")
     * @Versions({"v1"})
     * @Request({"token": "foo", "user_id":5})
     * @Response(200, body={
    "books": {
    {
    "id": 12,
    "title": "EngLib",
    "author": "Ruth D. Brown",
    "subject": "English",
    "internal" : "12-15",
    "get": "2015-09-11"
    },
    {
    "id": 13,
    "title": "SciLib",
    "author": "Matthew D. Stewart",
    "subject": "Science",
    "internal" : "158/59",
    "get": "2015-09-11"
    },
    },
    "user": {
    "id": 15,
    "name": "Full Name",
    "email": "address@sms.com",
    "address": "Kincheloe Road Portland",
    "mobile": "345376587657",
    "phone": "",
    "gender": 1
    }
    })
     */
    public function borrowedUserBooks(Request $request)
    {
        $rules = array(
            'user_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $books = BookUser::join('books', 'books.id', '=', 'book_users.book_id')
                ->whereNull('back')
                ->whereNotNull('get')
                ->whereNull('books.deleted_at')
                ->where('book_users.user_id', $request->input('user_id'))
                ->select(array('book_users.id', 'books.internal', 'books.title', 'books.author',
                    DB::raw('(SELECT title from subjects where subjects.id=books.subject_id) as subject'),
                    'book_users.get'))->get()->toArray();
            $user = User::where('id', $request->input('user_id'))
                ->select(array('id', 'first_name', 'last_name', 'picture',
                    'email', 'address', 'mobile', 'phone', 'gender'))->first()->toArray();
            return response()->json(['books' => $books, 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Books for subject
     *
     * Get all books for subject
     *
     * @Get("/subject_books")
     * @Versions({"v1"})
     * @Transaction({
    @Request({"token": "foo","subject_id":"5"}),
    @Response(200, body={
    "books": {
    {"id": "1",
    "title": "Book for mathematics",
    "author": "Group of authors",
    "year": "2015",
    "internal" : "15-14",
    "publisher": "Book publisher",
    "version": "0.2",
    "quantity": 2,
    "issued": 1}
    }
    }),
    @Response(500, body={"error":"not_valid_data"})
    })
     * })
     */
    public function subjectBooks(Request $request)
    {
        $rules = array(
            'subject_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $books = Book::where('subject_id', $request->input('subject_id'))
                ->select(array('books.id', 'books.title', 'books.author', 'books.year'
                , 'books.internal', 'books.publisher', 'books.version', 'books.quantity',
                    DB::raw('(SELECT count(id) FROM book_users as bu
                                WHERE bu.id= books.id AND bu.back IS NULL AND bu.get IS NOT NULL) as issued')
                ))->get()->toArray();
            return response()->json(['books' => $books], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get options for type
     *
     * @Get("/options_for_type")
     * @Versions({"v1"})
     * @Transaction({
    @Request({"token": "foo","category":"attendance_type|exam_type"}),
    @Response(200, body={
    "options": {
    {"id": "1",
    "category": "exam_type",
    "title": "Oral exam",
    "value": "Oral exam"}
    }
    }),
    @Response(500, body={"error":"not_valid_data"})
    })
     * })
     */
    public function optionsForType(Request $request)
    {
        $rules = array(
            'category' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $options = Option::where('category', $request->input('category'))->get()->toArray();
            return response()->json(['options' => $options], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get transportations and directions
     *
     * @Get("/transportations_directions")
     * @Versions({"v1"})
     * @Transaction({
    @Request({"token": "foo"}),
    @Response(200, body={
    "transport": {
    {"id": "1",
    "title": "Oral exam",
    "start": "12:50",
    "end": "15:15",
    "locations":{
    {"id":10, "name": "Location 1", "lat":0.124, "lang":0.124}
    }
    }
    }
    }),
    @Response(500, body={"error":"not_valid_data"})
    })
     * })
     */
    public function transportationsDirections(Request $request)
    {
        $rules = array(
            'token' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $transports = Transportation::select('id', 'title', 'start', 'end')->get()->toArray();
            foreach ($transports as &$transport) {
                $transport['locations'] = TransportationLocation::where('transportation_id', $transport['id'])->select('id', 'name', 'lat', 'lang')->get()->toArray();
            }
            return response()->json(['transport' => $transports], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }


    /**
     * Borrowed books
     *
     * Get all borrowed books
     *
     * @Get("/borrowed_books")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "books": {{"title": "Book for mathematics",
    "id":"12",
    "internal":"12-45",
    "author": "Group of authors",
    "get": "2015-08-10"}}
    })
     */
    public function borrowedBooks()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(['books' => BookUser::join('books', 'books.id', '=', 'book_users.book_id')
            ->where('book_users.user_id', $user->id)
            ->whereNotNull('get')
            ->whereNull('back')
            ->whereNull('books.deleted_at')
            ->select(array('books.title', 'books.internal', 'books.id', 'books.author', 'book_users.get'))->get()->toArray()], 200);
    }
}