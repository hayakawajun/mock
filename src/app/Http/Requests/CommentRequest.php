<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required | string | max:255'
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'コメントが入力されていません',
            'text.string' => 'コメントは文字列で入力してください',
            'text.max' => 'コメントは255文字以内で入力してください'
        ];
    }
}
