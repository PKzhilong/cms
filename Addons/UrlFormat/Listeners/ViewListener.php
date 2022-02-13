<?php


namespace Addons\UrlFormat\Listeners;


use Addons\UrlFormat\Events\ViewEvent;
use Addons\UrlFormat\Models\UrlFormat;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Models\Article;

class ViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ViewEvent $event
     * @return void
     */
    public function handle(ViewEvent $event)
    {

        $urlFormat = UrlFormat::where([
            ['model_type', '=', 'single'],
            ['alias', '=', $event->getName()],
        ])->first();

        if (isset($urlFormat->foreign_id)) {
            Article::where('id', $urlFormat->foreign_id)->update([
                'view' => DB::raw('view + 1'),
            ]);
        }

    }
}
