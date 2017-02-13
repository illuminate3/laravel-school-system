<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeacherSchool;
use Auth;
use Dingo\Api\Routing\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Sentinel;

/**
 * Authentication related endpoints
 *
 * @Resource("Auth", uri="/")
 */
class AuthController extends Controller
{
    use Helpers;

    /**
     * Login to system
     *
     * @Post("/login")
     * @Versions({"v1"})
     * @Transaction({
     *  @Request({"email": "foo","password": "bar"}),
     *  @Response(200, body={
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
     *   }),
     *   @Response(401, body={
    "error": "invalid_credentials"
     *   }),
     *   @Response(500, body={
    "error": "could_not_create_token"
     *   })
    })
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        Sentinel::authenticate($request->only('email', 'password'), $request['remember-me']);
        $user = Sentinel::getUser();
        if ($user->inRole('parent')) {
            $role = 'parent';
        } elseif ($user->inRole('student')) {
            $role = 'student';
        } elseif ($user->inRole('librarian')) {
            $role = 'librarian';
        } elseif ($user->inRole('teacher')) {
            $role = 'teacher';
        } else {
            $role = 'no_role';
        }
        $user = User::select('id', 'first_name', 'last_name', 'email', 'last_login',
            'address', 'picture', 'mobile', 'phone', 'gender', 'birth_date', 'birth_city')->find(Sentinel::getUser()->id);

        return response()->json(['token' => $token,
            'user' => $user,
            'role' => $role], 200);
    }

    /**
     * Refresh token
     *
     * @Get("/refresh")
     * @Versions({"v1"})
     * @Transaction({
     *  @Request({"token": "foo"}),
     *  @Response(200, body={
    "token": "token"
     *       }),
     *   @Response(500, body={
    "error": "could_not_create_token"
     * })
     * })
     */
    public function refreshToken()
    {
        try {
            $oldToken = JWTAuth::getToken();
            $token = JWTAuth::refresh($oldToken);
            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 401);
        }
    }

}