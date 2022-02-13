<?php


namespace Addons\Dedecms\Controllers;


use Addons\Dedecms\Models\Dedecms;
use Addons\Dedecms\Requests\DedeConfigRequest;
use App\Http\Controllers\MyAdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleTag;
use Modules\Cms\Models\ArticleTagRel;

class DedeController extends MyAdminController
{
    public $model = 'Addons\Dedecms\Models\Dedecms';

    private $lowerName = 'dedecms';

    public function config()
    {
        $systemConfig = system_config([], $this->lowerName);
        return $this->view('admin.config', compact('systemConfig'));
    }

    /**
     * 保存系统配置
     */
    public function storeCfg(DedeConfigRequest $request)
    {
        $data = $request->validated();

        $result = system_config_store($data, $this->lowerName);

        return $this->result($result);
    }

}
