<?php


namespace Addons\Ads\Pipeline;


use Closure;
use Expand\Pipeline\MyPipeline;

class AdPipeline implements MyPipeline
{

    public function handle($content, Closure $next)
    {
        $script = '<script src="' . route('addon.ads.entrance.js') . '"></script>';
        $script .= '<ins class="adsbycms" data-ad-code="' . $content . '"></ins>';

        return $next($script);
    }
}
