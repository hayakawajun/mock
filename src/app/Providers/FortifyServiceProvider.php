<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Responses\CustomRegisterResponse;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Requests\LoginRequest;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * ログアウト後の遷移先をログイン画面に指定。
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/login');
            }
        });

    /**
     * 新規登録後の遷移先をプロフィール編集画面に指定。作成したCustomRegisterResponse.phpをバインド。
     */

        $this->app->singleton(
        RegisterResponseContract::class,
        CustomRegisterResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        /**
         * FortifyLoginRequestが呼び出されたら、カスタムフォームリクエストを呼び出すよう、 LoginRequestをバインド。
         */
        $this->app->bind(FortifyLoginRequest::class,LoginRequest::class);
    }
}
