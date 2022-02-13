<?php


namespace Addons\BingSubmitUrl\Events;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BingSubmitUrlEvent
{
    protected $request;

    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getUrl(): string
    {
        $data = json_decode($this->response->getContent(), true);

        if (isset($data['id'])) {
            return single_path($data['id']);
        }

        return $data['url'];
    }
}
