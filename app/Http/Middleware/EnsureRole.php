<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware('role:warga') or ->middleware('role:admin')
     * You can also pass multiple roles separated by comma: 'role:admin,warga'
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles = '')
    {
        $user = $request->user();

        if (! $user) {
            // not authenticated
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->guest(route('login'));
        }

        $allowed = array_filter(array_map('trim', explode(',', $roles)));

        if (empty($allowed)) {
            // no role requirement
            return $next($request);
        }

        // Check if user has one of the allowed roles
        if (! in_array($user->role, $allowed, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], Response::HTTP_FORBIDDEN);
            }

            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
