<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ExternalConsultant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)

    {

        if(Auth::check()){
            if(Auth::user()->isExternalConsultant()){
                return $next($request);
            }
        }
        return redirect('/');
    }
}
