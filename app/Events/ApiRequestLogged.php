<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ApiRequestLogged
{
    use SerializesModels;

    public $request;

    /**
     * Crea una nuova istanza dell'evento.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
