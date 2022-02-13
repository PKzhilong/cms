<?php


namespace Addons\Dedecms\Requests;


use App\Http\Requests\MyRequest;

class DedeConfigRequest extends MyRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'host' => ['required'],
            'port' => ['required'],
            'database' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'batch_number' => [],
            'dede_prefix' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'host.required' => '数据库地址不能为空',
            'port.required' => '数据库端口不能为空',
            'database.required' => '数据库名称不能为空',
            'username.required' => '数据库账号不能为空',
            'password.required' => '数据库密码不能为空',
        ];
    }

}
