<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'postal_code' => 'required | string | regex:/^\d{3}-\d{4}$/',
            'address' => 'required | string | max:30',
            'building' => 'nullable | string | max:30'
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.string' => '郵便番号は文字列で入力してください',
            'postal_code.regex' => '郵便番号はハイフンありの8文字で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は30文字以内で入力してください',
            'building.string' => '建物名は文字列で入力してください',
            'building.max' => '建物名は30文字以内で入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $commonConditions = [
                'user_id' => auth()->id(),
                'postal_code' => $this->postal_code,
                'address' => $this->address,
                'building' => $this->building
            ];

            $existsInProfile = \DB::table('profiles')
                ->where($commonConditions)
                ->exists();

            if($existsInProfile){
                $validator->errors()->add('building','プロフィールと同一の住所は設定できません');
                return;
            }

            $existsInShipping = \DB::table('shipping_addresses')
                ->where($commonConditions)
                ->exists();

            if($existsInShipping){
                $validator->errors()->add('building','入力した住所はすでに登録されています');
            }
        });
    }
}
