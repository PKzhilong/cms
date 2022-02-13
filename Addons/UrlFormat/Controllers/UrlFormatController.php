<?php


namespace Addons\UrlFormat\Controllers;


use Addons\UrlFormat\Models\UrlFormat;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\System\Models\Config;

class UrlFormatController extends MyController
{

    protected $controller = 'Modules\Cms\Http\Controllers\Web\CmsController';

    public function category()
    {
        $category = request()->path();
        preg_match("/([a-zA-Z0-9\-\_]+)/",$category,$match);
        $category = $match[1] ?? $category;

        $urlFormat = UrlFormat::where([
            ['model_type', '=', 'category'],
            ['alias', '=', $category],
        ])->first();

        if (isset($urlFormat->foreign_id)) {
            return (new $this->controller())->category($urlFormat->foreign_id);
        }

       abort(404);
    }

    public function single($single)
    {
        $urlFormat = UrlFormat::where([
            ['model_type', '=', 'single'],
            ['alias', '=', $single],
        ])->first();

        if (isset($urlFormat->foreign_id)) {
            return (new $this->controller())->single($urlFormat->foreign_id);
        }

        abort(404);
    }

    public function tag($name)
    {
        $urlFormat = UrlFormat::where([
            ['model_type', '=', 'tag'],
            ['alias', '=', $name],
        ])->first();

        if (isset($urlFormat->foreign_id)) {
            return (new $this->controller())->tag($urlFormat->foreign_id);
        }

        abort(404);
    }

}
