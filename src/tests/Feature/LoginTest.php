<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目2：ログイン機能

    // メールアドレスが入力されていない場合、バリデーションメッセージが表示される。

    public function test_login_email_validation()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $inputData = [
            'email' => '',
            'password' => 'dummypass'
        ];

        $response = $this->post('/login',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    // パスワードが入力されていない場合、バリデーションメッセージが表示される。

    public function test_login_password_validation()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $inputData = [
            'email' => 'test@example.com',
            'password' => ''
        ];

        $response = $this->post('/login',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    // 入力情報が間違っている場合、バリデーションメッセージが表示される。

    public function test_login_input_mistake_validation()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('dummypass')
        ]);

        $inputData = [
            'email' => 'test@example.com',
            'password' => 'wrongpass'
        ];

        $response = $this->post('/login',$inputData);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'password' => 'ログイン情報が登録されていません'
        ]);
    }

    // 正しい情報が入力された場合、ログイン処理が実行される。

    public function test_login_success()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('dummypass')
        ]);

        $inputData = [
            'email' => 'test@example.com',
            'password' => 'dummypass'
        ];

        $response = $this->post('/login',$inputData);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect('/');
    }
}
