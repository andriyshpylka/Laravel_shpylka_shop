<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Session\Session;

class SetLocale
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
        App::setLocale(session('locale'));
        return $next($request);
    }
}