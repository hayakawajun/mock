<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required | string | max:40',
            'bland' => 'nullable | string | max:40',
            'description' => 'required | string | max:255',
            'status' => 'required | integer | in:1,2,3,4',
            'price' => 'required | integer | min:0 | max:300000',
            'image' => 'required | mimes:jpg,jpeg,png| max:5120',
            'category_ids' => 'array | required',
            'category_ids.*' => 'required | integer | exists:categories,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必ず入力してください',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は40文字以内で入力してください',
            'bland.string' => 'ブランド名は文字列で入力してください',
            'bland.max' => 'ブランド名は40文字以内で入力してください',
            'description.required' => '商品の説明は必ず入力してください',
            'description.string' => '商品の説明は文字列で入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'status.required' => '商品の状態は必ず選択してください',
            'price.required' => '販売価格は必ず入力してください',
            'price.integer' => '販売価格は数字で入力してください',
            'price.max' => '販売価格は30万円以下に設定してください',
            'category_ids.required' => 'カテゴリーは必ず1つ以上選択してください',
            'image.required' => '商品画像は必ずアップロードしてください',
            'image.mimes' => 'png, jpg, jpeg形式の画像ファイルのみアップロードできます',
            'image.max' => 'アップロードする画像のサイズは5MB未満にしてください'
        ];
    }
}
