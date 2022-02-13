<?php


namespace Addons\Ads\Controllers;


use Addons\Ads\Models\Ads;
use App\Http\Controllers\MyController;

class AdResourceController extends MyController
{
    public function entranceScript()
    {
        return str_replace(
            "{advert}",
            route("addon.ads.content.js"),
            file_get_contents(addon_path("Ads", "/Resources/Static/js/adsbycms.js"))
        );
    }

    public function contentScript()
    {
        return str_replace(
            "{content}",
            route("addon.ads.content"),
            file_get_contents(addon_path("Ads", "/Resources/Static/js/advert.js"))
        );
    }

    /**
     * 广告显示内容
     */
    public function content()
    {
        $code = $this->request('code');
        $forbid = $this->request('forbid') === 'undefined';
        $ad = Ads::where('code', $code)->first();

        return $ad ? ($forbid ?
            '<p><a href="' . route('addon.ads.jump', ['code' => $code]) . '" target="_blank"><img src="' . $ad->forbid_img . '"></a></p>'
            : $ad->content) : '';
    }

    public function jump($code)
    {
        $ad = Ads::where('code', $code)->first();

        if ($ad && $ad->forbid_url){
            return redirect()->to($ad->forbid_url);
        }

        abort(404);
    }
}
