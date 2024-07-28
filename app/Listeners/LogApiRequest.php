<?php

namespace App\Listeners;

use App\Events\ApiRequestLogged;
use Illuminate\Support\Facades\Log;

class LogApiRequest
{
    /**
     * Gestisce l'evento.
     *
     * @param  \App\Events\ApiRequestLogged  $event
     * @return void
     */
    public function handle(ApiRequestLogged $event)
    {
        $request = $event->request;
        $method = $request->method();
        $uri = $request->path();
        $payload = $request->all();
        $ip = $request->ip();
        // $user = $request->user() ? $request->user()->id : 'guest';

        Log::channel('access')->info('API Request', [
            'method' => $method,
            'uri' => $uri,
            'payload' => $payload,
            'ip' => $ip,
            // 'user' => $user,
        ]);
    }
}
