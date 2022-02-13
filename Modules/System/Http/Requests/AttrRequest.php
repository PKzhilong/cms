<?php


namespace Modules\System\Http\Requests;


use App\Http\Requests\MyRequest;

class AttrRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'ident' => ['required', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '名称不能为空',
            'name.max' => '名称长度错误',

            'ident.required' => '标识不能为空',
            'ident.max' => '标识长度错误',
        ];
    }
}
