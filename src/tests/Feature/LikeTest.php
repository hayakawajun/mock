<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目8：いいね機能

    // いいねアイコンを押下することによって、いいねした商品として登録することができる。

    public function test_like_store()
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

        $response = $this->actingAs($myself)->get(route('item.show',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(0, $viewItem->likers()->count());

            return true;
        });

        $response = $this->post(route('like.toggle',$dummyItem->id));
        $response->assertStatus(302);

        $this->assertDatabaseHas('likes',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id
        ]);

        $response = $this->get(route('item.show',$dummyItem->id));

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(1, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('1');
    }

    // 追加済みのアイコンは色が変化する。

    public function test_like_icon_colored()
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

        $response = $this->actingAs($myself)->get(route('item.show',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(0, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('<button class="like__btn">', false);
        $response->assertDontSee('<button class="like__btn--colored">', false);

        $response = $this->post(route('like.toggle',$dummyItem->id));
        $response->assertStatus(302);

        $this->assertDatabaseHas('likes',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id
        ]);

        $response = $this->get(route('item.show',$dummyItem->id));

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(1, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('1');

        $response->assertSee('<button class="like__btn--colored">', false);
        $response->assertDontSee('<button class="like__btn">', false);
    }

    // 再度いいねアイコンを押下することによって、いいねを解除することができる。

    public function test_like_icon_unlike()
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

        Like::create([
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id
        ]);

        $response = $this->actingAs($myself)->get(route('item.show',$dummyItem->id));
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(1, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('<button class="like__btn--colored">', false);
        $response->assertDontSee('<button class="like__btn">', false);

        $response = $this->post(route('like.toggle',$dummyItem->id));
        $response->assertStatus(302);

        $this->assertDatabaseMissing('likes',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id
        ]);

        $response = $this->get(route('item.show',$dummyItem->id));

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(0, $viewItem->likers()->count());

            return true;
        });

        $response->assertSee('0');

        $response->assertSee('<button class="like__btn">', false);
        $response->assertDontSee('<button class="like__btn--colored">', false);
    }
}
