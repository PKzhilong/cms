<?php


namespace Modules\System\Listeners;


use Illuminate\Support\Facades\Storage;
use Modules\System\Events\DiyPageRouteCacheEvent;
use Modules\System\Models\DiyPage;

class DiyPageRouteCacheListener
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
     * @param DiyPageRouteCacheEvent $event
     * @return void
     */
    public function handle(DiyPageRouteCacheEvent $event)
    {
        $pages = app('system')->diyPages();

        $route = "<?php\n";
        $route .= "Route::group(['namespace' => '\Modules\System\Http\Controllers\Web'], function () {\n";

        foreach ($pages as $page) {

            $route .= "\tRoute::get('{$page->page_path}', 'DiyPageWebController@show');\n";
        }

        $route .= "});\n";
        $route .= "\n?>";

        Storage::disk('root')->put('routes/diy-page.php', $route);
    }
}
