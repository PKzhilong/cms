<?php


namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class MyAdminController extends MyController
{

    public $model = '';

    public $request = '';

    public $view = 'admin.';


    public function __call($method, $parameters)
    {
        if (method_exists($this, "{$method}Action")) {
            return $this->{"{$method}Action"}();
        }

        parent::__call($method, $parameters);
    }

    /**
     * 获取关联模型
     */
    public function getModel(): Model
    {
        return (new $this->model);
    }

    /**
     * 获取管理请求对象
     */
    public function getRequest(): FormRequest
    {
        return app($this->request);
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        if (request()->ajax() && request()->wantsJson()) {
            $category = $this->getModel()::orderBy('id', 'desc')
                ->paginate($this->request('limit', 'intval'))->toArray();

            return $this->jsonSuc($category);
        }

        return $this->view($this->view . 'index');
    }

    /**
     * 创建页
     */
    public function createAction()
    {
        return $this->view($this->view . 'create');
    }

    /**
     * 创建记录
     */
    public function storeAction(): JsonResponse
    {
        $data = $this->getRequest()->validated();

        $result = $this->getModel()->store($data);

        return $this->result($result);
    }

    /**
     * 编辑页
     */
    public function editAction()
    {
        $data = $this->getModel()::find($this->request('id', 'intval'));

        return $this->view($this->view . 'edit', compact('data'));
    }

    /**
     * 更新记录
     */
    public function updateAction(): JsonResponse
    {

        if ($id = $this->request('id', 'intval')) {

            $data = $this->getRequest()->validated();
            $data['id'] = $id;

            $result = $this->getModel()->up($data);

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除记录
     */
    public function destroyAction(): JsonResponse
    {
        $result = $this->getModel()::destroy($this->request('id', 'intval'));
        return $this->result($result);
    }
}
