<?php


namespace Addons\Ads\Controllers;


use Addons\Ads\Models\Ads;
use App\Http\Controllers\MyAdminController;
use Illuminate\Support\Facades\Storage;

class AdsController extends MyAdminController
{

    public $model = 'Addons\Ads\Models\Ads';

    public $request = 'Addons\Ads\Requests\AdsRequest';

    /**
     * 预览
     */
    public function review()
    {
        $ad = Ads::find($this->request('id', 'intval'));

        return $this->view('admin.review', compact('ad'));
    }

    /**
     * 配置
     */
    public function config()
    {
        $config = system_config([], 'ad');
        return $this->view('admin.config', compact('config'));
    }

    /**
     * 保存配置
     */
    public function storeCfg()
    {
        $data = [
            'entrance_js' => $this->request('entrance_js'),
            'content_js' => $this->request('content_js'),
            'content_path' => $this->request('content_path'),
        ];

        $result = system_config_store($data, 'ad');

        $route = "<?php";
        $route .= "\nRoute::group(['namespace' => 'Addons\Ads\Controllers'], function () {";
        $route .= "\n\tRoute::get('/{$data['entrance_js']}', 'AdResourceController@entranceScript')->name('addon.ads.entrance.js');";
        $route .= "\n\tRoute::get('/{$data['content_js']}', 'AdResourceController@contentScript')->name('addon.ads.content.js');";
        $route .= "\n\tRoute::get('/{$data['content_path']}', 'AdResourceController@content')->name('addon.ads.content');";
        $route .= "\n});\n?>";

        Storage::disk("root")->put("/Addons/Ads/Routes/forbid.php", $route);

        return $this->result($result);
    }

}
