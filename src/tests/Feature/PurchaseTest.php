<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\ShippingAddress;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目10：商品購入機能

    //「購入する」ボタンを押下すると購入が完了する。

public function test_purchase_success()
    {
        $myself = User::factory()->create();
        $dummyUser = User::factory()->create();

        $dummyItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => 'テスト用商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 2,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpg'
        ]);

        $shippingAddress = ShippingAddress::create([
            'user_id' =>$myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所'
        ]);

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $inputData = [
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'address' => $shippingAddress->id
        ];

        $response = $this->post(route('item.payment',$inputData));

        $response = $this->get(route('payment.success'));
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => 'ダミー住所'
        ]);
    }

    // 購入した商品は商品一覧画面にて「sold」表示される。

    public function test_purchase_sold_out_label()
    {
        $myself = User::factory()->create();
        $dummyUser = User::factory()->create();

        $dummyItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => 'テスト用商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 2,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpg'
        ]);

        $shippingAddress = ShippingAddress::create([
            'user_id' =>$myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所'
        ]);

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $inputData = [
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'address' => $shippingAddress->id
        ];

        $response = $this->post(route('item.payment',$inputData));

        $response = $this->get(route('payment.success'));
        $response->assertStatus(302);
        $response->assertRedirect('/');

        $response = $this->get(route('item.index'));

        $response->assertViewHas('items', function ($viewItems) use ($dummyItem)
        {
            $dummyItemInView = $viewItems->find($dummyItem->id);

            $this->assertNotNull($dummyItemInView->purchase);

            return true;
        });

        $response->assertSeeInOrder([
            '<span class="sold">',
            'SOLD',
            '</span>'
        ], false);
    }

    //「プロフィール/購入した商品一覧」に追加されている。

    public function test_purchase_add_mypage_purchased_items()
    {
        $myself = User::factory()->create();
        $dummyUser = User::factory()->create();

        $dummyItem = Item::create([
            'user_id' => $dummyUser->id,
            'name' => 'テスト用商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 2,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpg'
        ]);

        $shippingAddress = ShippingAddress::create([
            'user_id' =>$myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所'
        ]);

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $inputData = [
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'address' => $shippingAddress->id
        ];

        $response = $this->post(route('item.payment',$inputData));

        $response = $this->get(route('payment.success'));
        $response->assertStatus(302);

        $response = $this->get(route('profile.index'));

        $response->assertViewHas('purchasedItems', function ($viewItems) use ($dummyItem)
        {
            $dummyItemInView = $viewItems->find($dummyItem->id);

            $this->assertNotNull($dummyItemInView->purchase);

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="purchased-items">',
            'テスト用商品',
            '</div>'
        ], false);
    }
}
