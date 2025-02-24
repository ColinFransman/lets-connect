<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Success
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $schedule = new Schedule;
        // if (!$schedule->find(auth()->user()->id)) {
        //     return redirect('/dashboard');
        // }

        return $next($request);
    }
}
