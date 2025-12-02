<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Str;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // テスト項目9：コメント送信機能

    // ログイン済みのユーザーはコメントを送信できる。

public function test_comment_post()
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
            $this->assertEquals(0, $viewItem->comments()->count());

            return true;
        });

        $inputData = [
            'item_id' => $dummyItem->id,
            'text' => 'とても便利な商品です'
        ];

        $response = $this->post(route('comment.post',$inputData));
        $response->assertStatus(302);

        $this->assertDatabaseHas('comments',[
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id,
            'text' => 'とても便利な商品です'
        ]);

        $response = $this->get(route('item.show',$dummyItem->id));

        $response->assertViewHas('item', function ($viewItem)
        {
            $this->assertEquals(1, $viewItem->comments()->count());

            return true;
        });

        $response->assertSee('1');

        $response->assertSeeInOrder([
            '<div class="comments">',
            'とても便利な商品です',
            '</div>'
        ], false);
    }

    // ログイン前のユーザーはコメントを送信できない。

    public function test_comment_guest_can_not_post()
    {
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

        $response = $this->get("/item/{$dummyItem->id}");
        $response->assertStatus(200);

        $response->assertViewIs('detail');

        $inputData = [
            'item_id' => $dummyItem->id,
            'text' => 'とても便利な商品です'
        ];

        $response = $this->post(route('comment.post',$inputData));
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments',[
            'item_id' => $dummyItem->id,
            'text' => 'とても便利な商品です'
        ]);

        $response->assertSessionHas('error', '操作を実行するにはログインが必要です');
    }

    // コメントが入力されていない場合、バリデーションメッセージが表示される。

    public function test_comment_text_empty_validation()
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

        $inputData = [
            'user_id' => $myself->id,
            'item_id' => $dummyItem->id,
            'text' => ''
        ];

        $response = $this->post(route('comment.post',$inputData));
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'text' =>  'コメントが入力されていません'
        ]);
    }

    // コメントが256文字以上の場合、バリデーションメッセージが表示される。

    public function test_comment_text_over_characters_validation()
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

        $invalidText = Str::repeat('a',256);

        $inputData = [
            'item_id' => $dummyItem->id,
            'text' => $invalidText
        ];

        $response = $this->post(route('comment.post',$inputData));
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'text' =>  'コメントは255文字以内で入力してください'
        ]);
    }
}
