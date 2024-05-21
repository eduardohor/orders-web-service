<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLoginAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $maxAttemptes = 3;
        $lockoutTime = 15; //minutes

        $attempts = DB::table('login_attempts')
            ->where('ip_address', $ipAddress)
            ->where('attempted_at', '>=', Carbon::now()->subMinutes($lockoutTime))
            ->count();

        if ($attempts >= $maxAttemptes) {
            return response()->json(['message' => 'Muitas tentativas de login. Por favor, tente novamente mais tarde'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
