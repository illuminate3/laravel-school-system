<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolDesktopApplication;
use App\Models\SchoolDesktopToken;
use App\Models\TeacherSchool;
use App\Models\User;
use App\Repositories\SchoolDirectionRepository;
use App\Repositories\TeacherSchoolRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use DB;
use Validator;
use JWTAuth;
use Sentinel;
use Rhumsaa\Uuid\Uuid;

/**
 * Admin endpoints, can be accessed only with Desktop applications
 *
 * @Resource("Admin", uri="/admin")
 */
class AdminController extends Controller
{
    use Helpers;

    /**
     * @var TeacherSchoolRepository
     */
    private $teacherSchoolRepository;
    /**
     * @var SchoolDirectionRepository
     */
    private $schoolDirectionRepository;

    /**
     * AdminController constructor.
     * @param TeacherSchoolRepository $teacherSchoolRepository
     * @param SchoolDirectionRepository $schoolDirectionRepository
     */
    public function __construct(TeacherSchoolRepository $teacherSchoolRepository,
                                SchoolDirectionRepository $schoolDirectionRepository)
    {
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->schoolDirectionRepository = $schoolDirectionRepository;
    }

    /**
     * Generate token
     *
     * @Get("/generate_token")
     * @Versions({"v1"})
     * @Request({"auth_id": "foo","auth_secure": "bar"})
     * @Response(200, body={"token": "token"})
     */
    public function generateToken(Request $request)
    {
        $rules = array(
            'auth_id' => 'required',
            'auth_secure' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $school = SchoolDesktopApplication::where('auth_id', $request->input('auth_id'))
                ->where('auth_secure', $request->input('auth_secure'))->first();

            if (!isset($school->school_id)) {
                return response()->json(['error' => 'not_valid_data'], 500);
            }
            $token = Uuid::uuid4();

            //SchoolDesktopToken::where('school_id',$school->school_id)->delete();

            $school_token = new SchoolDesktopToken();
            $school_token->school_id = $school->school_id;
            $school_token->token = $token->toString();
            $school_token->save();

            return response()->json(['token' => $token->toString()], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     *
     * Get all roles
     *
     * @Get("/roles")
     * @Versions({"v1"})
     * @Response(200, body={
    "roles": {
    {"id":1,
    "slug":"teacher",
    "name":"Teacher"
    },
    {"id":2,
    "slug":"student",
    "name":"Student"
    }}})
     */
    public function getRoles()
    {
        $roles = DB::select('select id,slug,name from roles');
        return response()->json(['roles' => $roles], 200);
    }

    /**
     *
     * Get all teachers
     *
     * @Get("/teachers")
     * @Versions({"v1"})
     * @Request({"school_id":"1","page":"2","limit":"10"}),
     * @Response(200, body={
    "teachers": {
    {"web_id":10,
    "email":"teacher@sms.com",
    "first_name":"Teacher",
    "last_name":"User",
    "address":"address",
    "mobile":"54545",
    "phone":null,
    "gender":0,
    "birth_date":"2016-24-05",
    "birth_city":"City",
    "school_id":1},
    },
    "total_pages": "15"
    })
     */
    public function getTeachers(Request $request)
    {
        $rules = array(
            'school_id' => 'required|integer',
            'page' => 'integer',
            'limit' => 'integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $teachers_array = $this->teacherSchoolRepository->getAllForSchool($request->input('school_id'))
                ->map(function ($teacher) use ($request) {
                    return [
                        'web_id' => $teacher->id,
                        'email' => $teacher->email,
                        'last_name' => $teacher->last_name,
                        'first_name' => $teacher->first_name,
                        'address' => $teacher->address,
                        'mobile' => $teacher->mobile,
                        'gender' => $teacher->gender,
                        'birth_date' => $teacher->birth_date,
                        'birth_city' => $teacher->birth_city,
                        'school_id' => $request->input('school_id'),
                    ];
                })->toArray();
            if ((int)$request->input('page') > 0 && (int)$request->input('limit') > 0) {
                $page = ($request->input('page') != "") ? (int)$request->input('page') : 0;
                $total = count($teachers_array); //total items in array
                $limit = ($request->input('limit') != "") ? (int)$request->input('limit') : 10;

                $totalPages = ceil($total / $limit); //calculate total pages
                $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
                $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
                $offset = ($page - 1) * $limit;
                if ($offset < 0) $offset = 0;

                $teachers = array_slice($teachers_array, $offset, $limit);
            } else {
                $teachers = $teachers_array;
                $totalPages = count($teachers_array);
            }
            return response()->json(['teachers' => $teachers, 'total_pages' => $totalPages], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Post new teachers
     *
     * @Post("/add_teachers")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(
    {"email" : {
    "teacher@sms.com",
    "teache125r@sms.com"
    },
    "password" : {
    "125125",
    "124563"
    },
    "first_name" : {
    "Teacher 22",
    "Teacher 28"
    },
    "last_name" : {
    "last_name 154",
    "last_name 757"
    },
    "address" : {
    "address 1",
    "address 15"
    },
    "mobile" : {
    "2154512",
    "7854545"
    },
    "birth_city" : {
    "City",
    "City"
    },
    "school_id" : {
    "1",
    "1"
    },
    "id" : {
    "5",
    "10"
    }}
    ),
    @Response(200, body={"success":"success",
    "return_array":{{"web_id":10,"email":"email1@sms.com","id":"5"},
    {"web_id":11,"email":"email2@sms.com","id":"6"}}}),
    @Response(500, body={"error":"not_valid_data"})
    })
     * })
     */
    public function addTeachers(Request $request)
    {
        $rules = array(
            'email.*' => 'required|email',
            'password.*' => 'required|min:6',
            'first_name.*' => 'required',
            'last_name.*' => 'required',
            'address.*' => 'required',
            'mobile.*' => 'required',
            'birth_city.*' => 'required',
            'school_id.*' => 'required|integer',
            'id.*' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $return_array = array();
            foreach ($request->input('email') as $key => $item) {
                $teacher = User::where('email', $request->input('email')[$key])->first();
                if(isset($teacher)) {
                    $user = Sentinel::registerAndActivate(['email' => $request->input('email')[$key],
                        'password' => $request->input('password')[$key]]);

                    $teacher = User::find($user->id);
                    $teacher->first_name = $request->input('first_name')[$key];
                    $teacher->last_name = $request->input('last_name')[$key];
                    $teacher->address = $request->input('address')[$key];
                    $teacher->mobile = $request->input('mobile')[$key];
                    $teacher->birth_city = $request->input('birth_city')[$key];
                    $teacher->save();
                }
                try {
                    $role = Sentinel::findRoleBySlug('teacher');
                    $role->users()->attach($teacher);
                } catch (\Exception $e) {
                }

                TeacherSchool::firstOrCreate(['user_id' => $teacher->id, 'school_id' => $request->input('school_id')[$key]]);

                $return_array[] = array('web_id' => $teacher->id, 'email' => $teacher->email, "id" => $request->input('id')[$key]);
            }
            return response()->json(['success' => 'success', 'return_array' => $return_array], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Edit teachers
     *
     * @Post("/edit_teachers")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(
    {"email" : {
    "teacher@sms.com",
    "teache125r@sms.com"
    },
    "password" : {
    "125125",
    "124563"
    },
    "first_name" : {
    "Teacher 22",
    "Teacher 28"
    },
    "last_name" : {
    "last_name 154",
    "last_name 757"
    },
    "address" : {
    "address 1",
    "address 15"
    },
    "mobile" : {
    "2154512",
    "7854545"
    },
    "birth_city" : {
    "City",
    "City"
    },
    "school_id" : {
    "1",
    "1"
    },
    "id" : {
    "5",
    "10"
    },
    "web_id" : {
    "1",
    "2"
    },
    "deleted_at" : {
    "",
    "2016-05-10 10:11:00"
    }}
    ),
    @Response(200, body={"success":"success",
    "return_array":{{"web_id":10,"email":"email1@sms.com","id":"5"},
    {"web_id":11,"email":"email2@sms.com","id":"6"}}}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function editTeachers(Request $request)
    {
        $rules = array(
            'web_id.*' => 'required',
            'email.*' => 'required|email',
            'first_name.*' => 'required',
            'last_name.*' => 'required',
            'address.*' => 'required',
            'mobile.*' => 'required',
            'birth_city.*' => 'required',
            'school_id.*' => 'required|integer',
            'id.*' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $return_array = array();
            foreach ($request->input('email') as $key => $item) {
                $teacher = User::where('id', $request->input('web_id')[$key])->first();
                $teacher->first_name = $request->input('first_name')[$key];
                $teacher->last_name = $request->input('last_name')[$key];
                $teacher->address = $request->input('address')[$key];
                $teacher->mobile = $request->input('mobile')[$key];
                $teacher->birth_city = $request->input('birth_city')[$key];
                $teacher->save();

                try {
                    $role = Sentinel::findRoleBySlug('teacher');
                    $role->users()->attach($teacher);
                } catch (\Exception $e) {
                }

                if (!isset($request->input('deleted_at')[$key]) && $request->input('deleted_at')[$key] == "") {
                    TeacherSchool::firstOrCreate(['user_id' => $teacher->id, 'school_id' => $request->input('school_id')[$key]]);
                } else {
                    TeacherSchool::where('user_id', $teacher->id)->where('school_id', $request->input('school_id')[$key])->delete();
                }

                $return_array[] = array('web_id' => $teacher->id, 'email' => $teacher->email, "id" => $request->input('id')[$key]);
            }
            return response()->json(['success' => 'success', 'return_array' => $return_array], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Post new teacher
     *
     * @Post("/add_teacher")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"email":"email@email.com", "password":"pas$w0rd", "first_name":"Name", "last_name":"Surname",
    "address":"Address", "mobile":"54545","birth_city": "City", "school_id": 1, "id": 1}),
     *      @Response(200, body={"success":"success",
    "return_array":  {"web_id": 5,"email": "email@email.com","id": 1}}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function addTeacher(Request $request)
    {
        $data = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'birth_city' => $request->input('birth_city'),
            'school_id' => $request->input('school_id'),
            'id' => $request->input('id'),

        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'birth_city' => 'required',
            'school_id' => 'required|integer',
            'id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $teacher = User::where('email', $request->input('email'))->first();
            if (!isset($teacher->id)) {
                $user = Sentinel::registerAndActivate(['email' => $request->input('email'),
                    'password' => $request->input('password')]);

                $teacher = User::find($user->id);
                $teacher->first_name = $request->input('first_name');
                $teacher->last_name = $request->input('last_name');
                $teacher->address = $request->input('address');
                $teacher->mobile = $request->input('mobile');
                $teacher->birth_city = $request->input('birth_city');
                $teacher->save();
            }
            try {
                $role = Sentinel::findRoleBySlug('teacher');
                $role->users()->attach($teacher);
            } catch (\Exception $e) {
            }

            TeacherSchool::firstOrCreate(['user_id' => $teacher->id, 'school_id' => $request->input('school_id')]);

            $return_array[] = array('web_id' => $teacher->id, 'email' => $teacher->email, "id" => $request->input('id'));

            return response()->json(['success' => 'success', 'return_array' => $return_array], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Edit teacher
     *
     * @Post("/edit_teacher")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"web_id":"1", "email":"email@email.com", "password":"pas$w0rd", "first_name":"Name", "last_name":"Surname",
    "address":"Address", "mobile":"54545","birth_city": "City", "school_id": 1, "id":"5", "deleted_at" : "2016-05-10 10:11:00"}),
     *      @Response(200, body={"success":"success", "return_array":  {
    "web_id": 1,
    "email": "email@email.com",
    "id": "5"
    }}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function editTeacher(Request $request)
    {
        $data = array(
            'web_id' => $request->input('web_id'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'birth_city' => $request->input('birth_city'),
            'school_id' => $request->input('school_id'),
            'id' => $request->input('id'),

        );
        $rules = array(
            'web_id' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'birth_city' => 'required',
            'school_id' => 'required|integer',
            'id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $teacher = User::where('id', $request->input('web_id'))->first();

            $teacher->first_name = $request->input('first_name');
            $teacher->last_name = $request->input('last_name');
            $teacher->address = $request->input('address');
            $teacher->mobile = $request->input('mobile');
            $teacher->birth_city = $request->input('birth_city');
            $teacher->save();

            try {
                $role = Sentinel::findRoleBySlug('teacher');
                $role->users()->attach($teacher);
            } catch (\Exception $e) {
            }

            if ($request->input('deleted_at') != null && $request->input('deleted_at') == "") {
                TeacherSchool::firstOrCreate(['user_id' => $teacher->id, 'school_id' => $request->input('school_id')]);
            } else {
                TeacherSchool::where('user_id', $teacher->id)->where('school_id', $request->input('school_id'))->delete();
            }
            $return_array[] = array('web_id' => $teacher->id, 'email' => $teacher->email, "id" => $request->input('id'));
            return response()->json(['success' => 'success', 'return_array' => $return_array], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     *
     * Get all directions for school
     *
     * @Get("/directions")
     * @Versions({"v1"})
     * @Request({"school_id":"1"}),
     * @Response(200, body={
    "directions": {
    {"web_id":10,
    "title":"Direction 1",
    "duration":"2"},
    },
    })
     */
    public function getDirections(Request $request)
    {
        $rules = array(
            'school_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $directions = $this->schoolDirectionRepository->getAllForSchool($request->input('school_id'))
                ->with('direction')
                ->get()
                ->map(function ($direction) {
                    return [
                        'web_id' => $direction->direction_id,
                        'title' => isset($direction->direction) ? $direction->direction->title : "",
                        'duration' => isset($direction->direction) ? $direction->direction->duration : ""
                    ];
                })->toArray();
            return response()->json(['directions' => $directions], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

}
