<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      if(Auth::check() && Auth::User()->activo) {
        return $next($request);
      }
      Auth::logout();
      return redirect()->route('login')->withMessage('hola');
    }
}
