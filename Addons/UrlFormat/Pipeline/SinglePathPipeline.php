<?php


namespace Addons\UrlFormat\Pipeline;


use Addons\UrlFormat\Models\UrlFormat;
use Closure;
use Expand\Pipeline\MyPipeline;
use Modules\Cms\Models\Article;

class SinglePathPipeline implements MyPipeline
{

    public function handle($content, Closure $next)
    {

        preg_match("/single\/([\d]+)/", $content, $match);

        $id = $match[1] ?? '';
        $format = UrlFormat::where([
            ['model_type', '=', 'single'],
            ['foreign_id', '=', $id]
        ])->first();

        if ($format) {

            $article = Article::where('id', $id)->first();
            $path = category_path($article->category_id);

            $content = "{$path}/{$format->alias}.html";
        }

        return $next($content);
    }
}
