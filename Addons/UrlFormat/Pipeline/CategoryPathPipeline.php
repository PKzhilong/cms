<?php


namespace Addons\UrlFormat\Pipeline;


use Addons\UrlFormat\Models\UrlFormat;
use Closure;
use Expand\Pipeline\MyPipeline;

class CategoryPathPipeline implements MyPipeline
{

    public function handle($content, Closure $next)
    {

        preg_match("/category\/([\d]+)/", $content, $match);

        $format = UrlFormat::where([
            ['model_type', '=', 'category'],
            ['foreign_id', '=', $match[1] ?? '']
        ])->first();

        $content = $format ? system_http_domain() . "/{$format->alias}" : $content;

        return $next($content);
    }
}
