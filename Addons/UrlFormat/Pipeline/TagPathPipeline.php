<?php


namespace Addons\UrlFormat\Pipeline;


use Addons\UrlFormat\Models\UrlFormat;
use Closure;
use Expand\Pipeline\MyPipeline;

class TagPathPipeline implements MyPipeline
{

    public function handle($content, Closure $next)
    {
        $config = system_config([], 'url_format');

        if (isset($config['url_format_status']) && $config['url_format_status'] == 1) {

            preg_match("/tag\/([\d]+)/", $content, $match);

            $format = UrlFormat::where([
                ['model_type', '=', 'tag'],
                ['foreign_id', '=', $match[1] ?? '']
            ])->first();

            if ($format) {
                $content = system_http_domain() ."/tag/{$format->alias}";
            }
        }

        return $next($content);
    }
}
