<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目15：出品商品情報登録

    // 商品出品画面にて必要な情報が保存できること。(カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格)

    public function test_exhibition_store()
    {
        Storage::fake('public');

        $myself = User::factory()->create();

        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => '家電']);
        $category3 = Category::create(['name' => 'インテリア']);

        $response = $this->actingAs($myself)->get(route('item.create'));
        $response->assertStatus(200);

        $response->assertViewIs('exhibition');

        $inputData = [
            'image' => UploadedFile::fake()->image('dummy.jpg'),
            'category_ids' =>[ $category2->id, $category3->id ],
            'status' => 1,
            'name' => 'テスト商品',
            'bland' => 'DAMMYS',
            'description' => 'ダミーアイテムです',
            'price' => '1000'
        ];

        $response = $this->post(route('item.store'),$inputData);
        $response->assertStatus(302);

        $exhibitedItem = Item::where('user_id',$myself->id)->first();

        //アップロードファイルはリサイズ後、ファイル名が変更されるため個別に検証します。
        $this->assertNotNull($exhibitedItem->image);

        $this->assertDatabaseHas('items',[
            'user_id' => $myself->id,
            'status' => 1,
            'name' => 'テスト商品',
            'bland' => 'DAMMYS',
            'description' => 'ダミーアイテムです',
            'price' => '1000'
        ]);

        $this->assertDatabaseHas('item_category',[
            'item_id' => $exhibitedItem->id,
            'category_id' => $category2->id
        ]);

        $this->assertDatabaseHas('item_category',[
            'item_id' => $exhibitedItem->id,
            'category_id' => $category3->id
        ]);
    }
}
