<?php


namespace Addons\UrlFormat\Events;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewEvent
{
    protected $name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->name = $request->route()->parameter('single');
    }


    public function getName(): string
    {
        return $this->name;
    }
}
