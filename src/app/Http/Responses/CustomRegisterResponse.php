<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return redirect('/mypage/profile')->with('success','会員登録が完了しました　続けてプロフィールを入力してください');
    }
}