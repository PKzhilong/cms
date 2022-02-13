<?php


namespace Addons\BingSubmitUrl\Controllers;


use Addons\BingSubmitUrl\Models\BingSubmitLog;
use Addons\BingSubmitUrl\Requests\ConfigRequest;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;

class SubmitController extends MyController
{
    private $lowerName = 'bing_submit_url';

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $logs = BingSubmitLog::orderBy('id', 'desc')
                ->paginate($this->request('limit', 'intval'))->toArray();

            return $this->jsonSuc($logs);
        }

        return $this->view('admin.index');
    }

    public function config()
    {
        $systemConfig = system_config([], $this->lowerName);
        return $this->view('admin.config', compact('systemConfig'));
    }

    /**
     * 保存系统配置
     */
    public function store(ConfigRequest $request)
    {
        $data = $request->validated();

        $result = system_config_store($data, $this->lowerName);

        return $this->result($result);
    }

    public function create()
    {
        return $this->view('admin.create');
    }

    public function push()
    {
        $urls = $this->request('urls');
        bing_submit_url($urls);

        return $this->result(true);
    }
}
