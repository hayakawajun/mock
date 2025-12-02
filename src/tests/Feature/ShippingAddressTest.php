<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\ShippingAddress;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目12：配送先変更機能

    // 送付先住所変更画面にて登録した住所が商品購入画面に反映されている。

public function test_shipping_address_store()
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

        Profile::create([
            'user_id' => $myself->id,
            'postal_code' => '000-0000',
            'address' => 'プロフィール住所'
        ]);

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $response->assertViewHas('shippingAddresses', function ($addresses)
        {
            $this->assertEmpty($addresses);

            return true;
        });

        $response = $this->get(route('address.create',$dummyItem->id,));
        $response->assertStatus(200);

        $response->assertViewIs('shipping_address');

        $inputData = [
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル'
        ];

        $response = $this->post(route('address.update',$dummyItem->id),$inputData);
        $response->assertStatus(302);
        $response->assertRedirect(route('item.order',$dummyItem->id));

        $response = $this->get(route('item.order',$dummyItem->id));

        $this->assertDatabaseHas('shipping_addresses',[
            'user_id' => $myself->id,
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル'
        ]);

        $response->assertViewHas('shippingAddresses', function ($addresses)
        {
            $this->assertNotNull($addresses);

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="delivery-address__text">',
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル',
            '</div>'
        ], false);
    }

    // 購入した商品に送付先住所が紐づいて登録される。

    public function test_shipping_address_links_to_purchased_item()
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

        Profile::create([
            'user_id' => $myself->id,
            'postal_code' => '000-0000',
            'address' => 'プロフィール住所'
        ]);

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $response = $this->get(route('address.create',$dummyItem->id,));
        $response->assertStatus(200);

        $response->assertViewIs('shipping_address');

        $inputData = [
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル'
        ];

        $response = $this->post(route('address.update',$dummyItem->id),$inputData);
        $response->assertStatus(302);
        $response->assertRedirect(route('item.order',$dummyItem->id));

        $response = $this->get(route('item.order',$dummyItem->id));

        $shippingAddress = ShippingAddress::where('user_id',$myself->id)->first();

        $paymentData = [
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'address' => $shippingAddress->id
        ];

        $response = $this->post(route('item.payment',$paymentData));

        $response = $this->get(route('payment.success'));
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => 'ダミー住所',
            'building' => 'ダミービル'
        ]);
    }
}
