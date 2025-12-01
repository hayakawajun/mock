<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目7：商品詳細情報取得

    // 必要な情報が表示される。(商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、
    // 商品情報(カテゴリ、商品の状態)、コメント数、コメントしたユーザー情報、コメント内容)

    public function test_item_detail()
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create(['name' => 'コメントしたユーザーの名前']);
        $thirdUser = User::factory()->create();

        $dummyItem = Item::create([
            'user_id' => $firstUser->id,
            'name' => 'テスト用商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 4,  //「1」はビュー上で「状態が悪い」の表示に変換されます
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpg'
        ]);

        $category = Category::create(['name' => 'ファッション']);
        $categoryId = [$category->id];
        $dummyItem->categories()->sync($categoryId);

        Like::create([
            'user_id' => $secondUser->id,
            'item_id' => $dummyItem->id
        ]);
        Like::create([
            'user_id' => $thirdUser->id,
            'item_id' => $dummyItem->id
        ]);

        Comment::create([
            'user_id' => $secondUser->id,
            'item_id' => $dummyItem->id,
            'text' => 'とても便利な商品です'
        ]);

        $response = $this->get("/item/{$dummyItem->id}");
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $response->assertSee('テスト用商品');
        $response->assertSee('DUMMYS');
        $response->assertSee('ダミーアイテムです');
        $response->assertSee('ファッション');
        $response->assertSee('状態が悪い');
        $response->assertSee('9,999');
        $response->assertSee('item_image/dummy_item.jpg', false);

        $response->assertViewHas('item', function ($viewItem) {
            $this->assertEquals(2, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('2');

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(1, $viewItem->comments()->count());

            return true;
        });

        $response->assertSee('1');

        $response->assertSeeInOrder([
            '<div class="comments">',
            'コメントしたユーザーの名前',
            'とても便利な商品です',
            '</div>'
        ], false);
    }

    // 複数選択されたカテゴリが表示されているか。

    public function test_item_detail_multiple_categories()
    {
        $firstUser = User::factory()->create();

        $dummyItem = Item::create([
            'user_id' => $firstUser->id,
            'name' => 'テスト用商品',
            'bland' => 'DUMMYS',
            'description' => 'ダミーアイテムです',
            'status' => 4,
            'price' => 9999,
            'image' => 'item_image/dummy_item.jpg'
        ]);

        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => '家電']);
        $category3 = Category::create(['name' => 'インテリア']);
        $categoryIds = [$category2->id,$category3->id];
        $dummyItem->categories()->sync($categoryIds);

        $response = $this->get("/item/{$dummyItem->id}");
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $response->assertViewHas('item', function ($viewItem) use ($categoryIds)
        {
            $this->assertCount(2, $viewItem->categories);

            $attachedIds = $viewItem->categories->pluck('id')->toArray();

            $this->assertEquals($categoryIds,$attachedIds);
            $this->assertTrue($viewItem->categories->contains('name','家電'));
            $this->assertTrue($viewItem->categories->contains('name','インテリア'));

            return true;
        });

        $response->assertSeeInOrder([
            '<div class="category-names">',
            '家電',
            'インテリア',
            '</div>'
        ], false);
    }
}
