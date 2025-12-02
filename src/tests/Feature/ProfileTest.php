<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目14：ユーザー情報変更

    // 変更項目が初期値として過去設定されていること。(プロフィール画像、ユーザー名、郵便番号、住所)

    public function test_profile_edit()
    {
        $myself = User::factory()->create(['name' => 'わたし']);

        $myProfile = Profile::create([
            'user_id' => $myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル',
            'image' => 'profile_image/dummy.jpg'
        ]);

        $response = $this->actingAs($myself)->get(route('profile.show'));
        $response->assertStatus(200);

        $response->assertViewIs('profile');

        $response->assertViewHas('profile', function ($viewProfile) use ($myself,$myProfile)
        {
            $this->assertNotNull($viewProfile->find($myself->id));
            $this->assertNotNull($viewProfile->find($myProfile->id));

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="user-image">',
            'profile_image/dummy.jpg',
            '</div>'
        ], false);

        $response->assertSee('わたし');
        $response->assertSee('123-4567');
        $response->assertSee('ダミー住所');
        $response->assertSee('ダミービル');
    }
}
