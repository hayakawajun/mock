<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $user = Auth::user();
        $like = $user->likedItems()->toggle($item->id);

            if(count($like['attached']) > 0){
                return back()->with('success','この商品をマイリストに追加しました');

            }else{
                return back()->with('success','この商品をマイリストから削除しました');
            }
    }
}
