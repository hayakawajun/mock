<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Category;
use App\Models\Purchase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目13：ユーザー情報取得

    // 必要な情報が取得できる。(プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧)

    public function test_mypage_index_items()
    {
        $myself = User::factory()->create(['name' => 'わたし']);
        $dummyUser = User::factory()->create();

        $myProfile = Profile::create([
            'user_id' => $myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル',
            'image' => 'profile_image/dummy.jpg'
        ]);

        $exhibitedItem = Item::create([
            'user_id' => $myself->id,
            'name' => '出品した商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 4,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpgA'
        ]);
        $purchasedItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => '購入した商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 4,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpgB'
        ]);

        Purchase::create([
            'user_id' => $myself->id,
            'item_id' => $purchasedItem->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル'
        ]);

        $response = $this->actingAs($myself)->get(route('profile.index'));
        $response->assertStatus(200);

        $response->assertViewIs('mypage');

        $response->assertViewHas('profile', function ($viewProfile) use ($myProfile)
        {
            $this->assertNotNull($viewProfile->find($myProfile->id));

            return true;
        });

        $response->assertViewHas('exhibitedItems', function ($viewItems) use ($exhibitedItem)
        {
            $this->assertNotNull($viewItems->find($exhibitedItem->id));

            return true;
        });

        $response->assertViewHas('purchasedItems', function ($viewItems) use ($purchasedItem)
        {
            $this->assertNotNull($viewItems->find($purchasedItem->id));

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="user-profile">',
            'profile_image/dummy.jpg',
            'わたし',
            '</div>'
        ], false);

        $response->assertSeeInOrder([
            '<div class="exhibited-items">',
            '出品した商品',
            '</div>'
        ], false);

        $response->assertSeeInOrder([
            '<div class="purchased-items">',
            '購入した商品',
            '</div>'
        ], false);
    }
}
