<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Routing\Helpers;
use Sentinel;
use JWTAuth;

class ApiStudent
{
    use Helpers;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user->inRole('student')) {
            return response()->json(['error' => 'could_not_access'], 500);
        }
        return $next($request);
    }
}
