<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Comment;


class ItemController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)->with('purchase')->get();
            $likes = $user->likedItems()->with('purchase')->get();

            return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->get();

            return view('index',compact('items'));
        }
    }

    public function search(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)
                ->ItemSearch($request->keyword)->with('purchase')->get();
            $likes = $user->likedItems()
                ->ItemSearch($request->keyword)->with('purchase')->get();

                return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->ItemSearch($request->keyword)->get();

            return view('index',compact('items'));
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $item = Item::withExists(['likers as liked_by_user' => function ($query) use ($user){
            if($user){
                $query->where('user_id',$user->id);
            }
        }])
        ->withCount('likers')
        ->with(['categories','purchase'])
        ->with([
            'comments' => function ($query){
                $query->with('user.profile');
            }
        ])
        ->withCount('comments')
        ->findOrFail($id);

        return view('detail',compact('item'));
    }
}
