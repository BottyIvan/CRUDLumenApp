<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use App\Events\ApiRequestLogged;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        Event::dispatch(new ApiRequestLogged($request));
        return $next($request);
    }
}
