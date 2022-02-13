<?php


namespace Modules\System\Http\Requests;


use App\Http\Requests\MyRequest;

class DiyPageRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_name' => ['required', 'max:255'],
            'page_path' => ['required', 'max:255'],
            'page_content' => ['required', 'max:255'],
            'page_title' => ['max:255'],
            'page_keyword' => ['max:255'],
            'page_desc' => ['max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'page_name.required' => '名称不能为空',
            'page_name.max' => '名称长度错误',

            'page_path.required' => '地址不能为空',
            'page_path.max' => '地址长度错误',

            'page_content.required' => '内容不能为空',
            'page_content.max' => '内容长度错误',

            'page_title.max' => '标题长度错误',
            'page_keyword.max' => '关键词长度错误',
            'page_desc.max' => '描述长度错误',
        ];
    }
}
