<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PaymentSelectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目11：支払い方法選択機能

    /** 小計画面で変更が反映される。
     *
     * [ このテスト項目について ]
     * セレクトボックスの選択値は、Javascriptを用いて小計エリアに即時反映させています。
     * phpunitを使用しての検証はできないため、
     * 意図的に「address」を未入力で送信してバリデーションエラーを発生させ、
     * 小計エリアの「未選択」テキストが、oldヘルパーを使用した送信直前のセッション値「コンビニ払い」
     * にテキスト表示が変わっているか、という方法で検証を行なっています。
     */

    public function test_payment_select()
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

        $response = $this->actingAs($myself)->get(route('item.order',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('purchase');

        $response->assertSeeInOrder([
            '<span id="payment__display-area">',
            '未選択',
            '</span>'
        ], false);

        $inputData = [
            'item_id' => $dummyItem->id,
            'payment' => 'コンビニ払い',
            'address' => ''
        ];

        $response = $this->post(route('item.payment',$inputData));
        $response->assertStatus(302);

        $response = $this->get(route('item.order',$dummyItem->id));

        $response->assertSeeInOrder([
            '<span id="payment__display-area">',
            'コンビニ払い',
            '</span>'
        ], false);
    }
}
