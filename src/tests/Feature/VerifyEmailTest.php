<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    // テスト項目16：メール認証機能

    // 会員登録後、認証メールが送信される。

    public function test_verify_email_send()
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
        $response->assertStatus(302);
        $response->assertRedirect('http://localhost/email/verify');

        $user = User::where('email','test@example.com')->first();
        $this->assertNotNull($user);

        Notification::assertSentTo(
            $user,
            VerifyEmail::class,
            function ($notification) use ($user) {
                return $notification->id !== null;
            }
        );
    }

    // メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する。


    // メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する。

    public function test_verify_email_redirect_profile_edit()
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

        $response = $this->get(route('profile.show'));
        $response->assertStatus(200);

        $response->assertViewIs('profile');
    }
}

