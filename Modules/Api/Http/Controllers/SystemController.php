<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\JsonResponse;

class SystemController extends ApiController
{

    /**
     * 返回系统时间戳
     * @return JsonResponse
     */
    public function timestamp(): JsonResponse
    {
        return $this->success(['result' => ['timestamp' => time()]]);
    }

    /**
     * 返回地区
     * @return JsonResponse
     */
    public function region(): JsonResponse
    {
        $pid = $this->request('pid', 'intval', 0);
        $regions = app('system')->regions($pid);

        return $this->success(['result' => $regions]);
    }

    /**
     * 辅助属性
     * @return JsonResponse
     */
    public function attrs(): JsonResponse
    {
        $attrs = app('system')->attributes();

        return $this->success([
            'result' => $this->collectFilterField(
                $attrs, ['created_at', 'updated_at'], true
            )
        ]);
    }

}
