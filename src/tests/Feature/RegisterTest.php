<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目1：会員登録機能

    // 名前が入力されていない場合、バリデーションメッセージが表示される。

    public function test_register_name_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'dummypass',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください'
        ]);
    }

    // メールアドレスが入力されていない場合、バリデーションメッセージが表示される。

    public function test_register_email_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => 'テスト',
            'email' => '',
            'password' => 'dummypass',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される。

    public function test_register_password_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    // パスワードが7文字以下の場合、バリデーションメッセージが表示される。

    public function test_register_password_short_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    // パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される。

    public function test_register_password_match_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'fakepass',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません'
        ]);
    }

    // 全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される。
    // メール認証機能を実装している為、一部テスト内容が「テスト項目16」と重複します。

    public function test_register_success()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $inputData = [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'dummypass',
            'password_confirmation' => 'dummypass'
        ];

        $response = $this->post('/register',$inputData);

        $this->assertDatabaseHas('users',[
            'name' => 'テスト',
            'email' => 'test@example.com'
        ]);

        $this->assertCredentials([
            'email' => 'test@example.com',
            'password' => 'dummypass'
        ]);

        $response->assertRedirect('/email/verify');

        $user = User::where('email','test@example.com')->first();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->get($verificationUrl);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        $response->assertRedirect('mypage/profile');
    }
}

