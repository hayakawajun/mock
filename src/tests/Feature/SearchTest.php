<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目6：商品検索機能

    // 「商品名」で部分一致検索ができる。

    public function test_search_items()
    {
        $dummyUser = User::factory()->create();

        Item::create([
            'user_id' => $dummyUser->id,
            'name' => '検索したいアイテム',
            'description' => 'ダミーアイテムです',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        Item::create([
            'user_id' => $dummyUser->id,
            'name' => '普通のアイテム',
            'description' => 'ダミーアイテムです',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        $searchKeyword = '検　アイ';
        $response = $this->get('/search?keywords='.$searchKeyword);
        $response->assertStatus(200);

        $response->assertViewIs('index');

        $response->assertSeeInOrder([
            '<div class="items__index">',
            '検索したいアイテム',
            '</div>'
        ], false);

        $response->assertDontSee('普通のアイテム');
    }

    // 検索状態がマイリストでも保持されている。

    public function test_search_items_in_my_list()
    {
        $myself = User::factory()->create();
        $dummyUser = User::factory()->create();

        $favoriteItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => 'いいねしたアイテム',
            'description' => 'ダミーアイテムです',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        $notFavoriteItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => 'いいねしていないアイテム',
            'description' => 'ダミーアイテムです',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);
        Item::create([
            'user_id' => $dummyUser->id,
            'name' => '普通のアイテム',
            'description' => 'ダミーアイテムです',
            'status' => 3,
            'price' => 3000,
            'image' => 'item_image/dummy_item_C.jpg'
        ]);

        Like::create([
            'user_id' => $myself->id,
            'item_id' => $favoriteItem->id
        ]);

        $response = $this->actingAs($myself)->get('/');

        $searchKeyword = 'いいね';
        $response = $this->get('/search?keywords='.$searchKeyword);
        $response->assertStatus(200);

        $response->assertViewIs('index');

        $response->assertSeeInOrder([
            '<div class="items__mylist">',
            'いいねしたアイテム',
            '</div>'
        ], false);

        $response->assertSeeInOrder([
            '<div class="items__index">',
            'いいねしていないアイテム',
            '</div>'
        ], false);

        $response->assertDontSee('普通のアイテム');

        $response->assertSee('name="keywords" value="'. $searchKeyword .'"', false);
    }
}