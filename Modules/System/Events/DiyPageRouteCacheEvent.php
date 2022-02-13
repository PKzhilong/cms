<?php


namespace Modules\System\Events;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiyPageRouteCacheEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {

    }
}
