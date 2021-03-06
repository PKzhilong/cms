<?php


namespace Modules\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * 用户登录
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('name', 'password');

        var_dump(Auth::guard('web')->attempt($credentials));exit;

        $user = app('user')->user($username);
        if (Auth::guard('web')->attempt())

        if ($user && $user->status == 1 && Hash::check($password, $user->password)) {
            return $this->success([
                'result' => $this->objectFilterField($user, ['password', 'status', 'remember_token'], true)
            ]);
        }

        return $this->error(['msg' => "验证失败"]);

    }

    /**
     * 会员注册
     * @return JsonResponse
     */
    public function reg(): JsonResponse
    {
        $username = $this->request("username");
        $password = $this->request("password");
        $mobile = $this->request("mobile");

        if (
            !empty($username) &&
            !empty($password) &&
            $uid = app('user')->generateUser($username, $password, $mobile)
        ) {

            return $this->success(['result' => $uid]);
        }

        return $this->error(['msg' => "注册失败"]);
    }

    /**
     * 会员信息
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        $id = $this->request("id");
        $user = app('user')->user($id);

        return $user ? $this->success([
            'result' => $this->objectFilterField(
                app('user')->userFields($user), ['password', 'remember_token'], true
            )
        ]) : $this->error(['msg' => "获取失败"]);
    }

    /**
     * 会员等级列表
     * @return JsonResponse
     */
    public function ranks(): JsonResponse
    {
        $ranks = app('user')->ranks();

        return $this->success([
            'result' => $this->collectFilterField(
                $ranks, ['created_at', 'updated_at'], true
            )
        ]);
    }
}
