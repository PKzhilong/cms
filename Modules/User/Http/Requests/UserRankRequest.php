<?php


namespace Modules\User\Http\Requests;


use App\Http\Requests\MyRequest;

class UserRankRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'number' => ['integer'],
            'description' => ['max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '等级名称不能为空',
            'name.max' => '等级名称不能超过255个字符',

            'rank_number.integer' => '等级代号必须是数字',
            'description.max' => '等级描述不能超过255个字符',
        ];
    }
}
