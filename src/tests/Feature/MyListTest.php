<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目5：マイリスト一覧取得

    // いいねした商品だけが表示される。

    public function test_my_list_favorite_only()
    {
        $myself = User::factory()->create();
        $others = User::factory()->create();

        $favoriteItem = Item::create([
            'user_id' => $others->id,
            'name' => 'お気に入りのアイテム',
            'description' => 'いいねしたアイテム',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        $notFavoriteItem = Item::create([
            'user_id' => $others->id,
            'name' => '別に普通のアイテム',
            'description' => 'いいねしていないアイテム',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        Like::create([
            'user_id' => $myself->id,
            'item_id' => $favoriteItem->id
        ]);

        $response = $this->actingAs($myself)->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('likes', function ($viewLikes) use ($favoriteItem, $notFavoriteItem){
            $this->assertNotNull($viewLikes->find($favoriteItem->id));
            $this->assertNull($viewLikes->find($notFavoriteItem->id));

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="items__mylist">',
            'お気に入りのアイテム',
            '</div>'
        ], false);

        $response->assertSeeInOrder([
            '<div class="items__index">',
            '別に普通のアイテム',
            '</div>'
        ], false);
    }

    // 購入済み商品は「sold」と表示される。

    public function test_my_list_favorite_only_sold_out()
    {
        $myself = User::factory()->create();
        $others = User::factory()->create();
        $buyer = User::factory()->create();

        $soldFavoriteItem = Item::create([
            'user_id' => $others->id,
            'name' => '購入済みのお気に入りのアイテム',
            'description' => '購入済みのいいねしたアイテム',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        $onSaleNotFavoriteItem = Item::create([
            'user_id' => $others->id,
            'name' => '販売中の別に普通のアイテム',
            'description' => '販売中のいいねしていないアイテム',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        Like::create([
            'user_id' => $myself->id,
            'item_id' => $soldFavoriteItem->id
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $soldFavoriteItem->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都'
        ]);

        $response = $this->actingAs($myself)->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('likes', function ($viewLikes) use ($soldFavoriteItem, $onSaleNotFavoriteItem){
            $favoriteItemInView = $viewLikes->find($soldFavoriteItem->id);
            $this->assertNotNull($favoriteItemInView);
            $this->assertNotNull($favoriteItemInView->purchase);

            $this->assertNull($viewLikes->find($onSaleNotFavoriteItem->id));

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="items__mylist">',
            '購入済みのお気に入りのアイテム',
            '<span class="sold">',
            'SOLD',
            '</span>',
            '</div>'
        ], false);

        $response->assertSeeInOrder([
            '<div class="items__index">',
            '販売中の別に普通のアイテム',
            '</div>'
        ], false);
    }

    // 未認証の場合は何も表示されない。

    public function test_my_list_guest_user_case()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertDontSee('<div class="items__mylist">', false);
    }
}
