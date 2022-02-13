<?php


namespace Addons\BingSubmitUrl\Listeners;


use Addons\BingSubmitUrl\Events\BingSubmitUrlEvent;

class BingSubmitUrlListener
{
    /**
     * Handle the event.
     *
     * @param BingSubmitUrlEvent $event
     */
    public function handle(BingSubmitUrlEvent $event)
    {
        $url = $event->getUrl();

        bing_submit_url($url);

    }
}
