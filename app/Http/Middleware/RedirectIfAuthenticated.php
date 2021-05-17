<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guamain-wrapper-1rd
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            /** @var User $user */
            $user = Auth::user();
            
            if ($user->hasRole('Admin')) {
                return \Redirect::to(RouteServiceProvider::ADMIN_HOME);
            }

            if ($user->hasRole('Employer')) {
                return \Redirect::to(RouteServiceProvider::EMPLOYER_HOME);
            }

            if ($user->hasRole('Candidate')) {
                return \Redirect::to(RouteServiceProvider::CANDIDATE_HOME);
            }
        }

        return $next($request);
    }
}
