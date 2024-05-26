<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $name)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(
                [
                    'message'  => __("unauthenticated")
                ],
                401
            );
        }

        $role = $user
            ?->roles()
            ?->where('name', $name)
            ?->first();

        if (!$role) {
            return response()->json(
                [
                    'message' =>  __("you have not role '$name' to access this resource")
                ],
                401
            );
        }

        return $next($request);
    }
}
