<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目3：ログアウト機能

    // ログアウトができる。

    public function test_logout_success()
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

        $response = $this->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
