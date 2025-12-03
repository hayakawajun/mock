<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目4：商品一覧取得

    // 全商品を取得できる。

    public function test_index_all_items()
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        Item::create([
            'user_id' => $firstUser->id,
            'name' => 'アイテムA',
            'description' => 'ダミーアイテムAです',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        Item::create([
            'user_id' => $secondUser->id,
            'name' => 'アイテムB',
            'description' => 'ダミーアイテムBです',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        $items =Item::all();

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('アイテムA');
        $response->assertSee('アイテムB');

        $response->assertViewIs('index');

        $response->assertViewHas('items', function ($viewItems) use ($items)
        {
            return  $viewItems->count() === $items->count() &&
                    $viewItems->first()->name === $items->first()->name;
        });
    }

    // 購入済み商品は「sold」と表示される。

    public function test_index_sold_out_label()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $soldItem = Item::create([
            'user_id' => $seller->id,
            'name' => 'アイテムA',
            'description' => 'アイテムAは購入済み',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        $onSaleItem = Item::create([
            'user_id' => $seller->id,
            'name' => 'アイテムB',
            'description' => 'アイテムBは販売中',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $soldItem->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都'
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('items', function ($viewItems) use ($soldItem, $onSaleItem)
        {
            $soldItemInView = $viewItems->find($soldItem->id);

            $this->assertNotNull($soldItemInView->purchase);

            $onSaleItemInView = $viewItems->find($onSaleItem->id);

            $this->assertNull($onSaleItemInView->purchase);

            return true;
        });

        $response->assertSeeInOrder([
            '<span class="sold">',
            'SOLD',
            '</span>'
        ], false);
    }

    // 自分が出品した商品は表示されない。

    public function test_index_my_item_not_display()
    {
        $myself = User::factory()->create();
        $others = User::factory()->create();

        $myItem = Item::create([
            'user_id' => $myself->id,
            'name' => '自分のアイテム',
            'description' => '自分が出品したアイテム',
            'status' => 1,
            'price' => 1000,
            'image' => 'item_image/dummy_item_A.jpg'
        ]);
        $othersItem = Item::create([
            'user_id' => $others->id,
            'name' => '他者のアイテム',
            'description' => '他者が出品したアイテム',
            'status' => 2,
            'price' => 2000,
            'image' => 'item_image/dummy_item_B.jpg'
        ]);

        $response = $this->actingAs($myself)->get('/');
        $response->assertStatus(200);

        $response->assertDontSee('自分のアイテム');
        $response->assertSee('他者のアイテム');

        $response->assertViewHas('items', function ($viewItems) use ($myItem, $othersItem)
        {
            $this->assertNull($viewItems->find($myItem->id));
            $this->assertNotNull($viewItems->find($othersItem->id));

            return true;
        });
    }
}
