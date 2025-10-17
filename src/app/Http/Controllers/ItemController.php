<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;


class ItemController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)->get();
            $likes = $user->likedItems;
            return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->get();
            return view('index',compact('items'));
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        session()->put('search_keyword',$keyword);

        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)
                ->ItemSearch($request->keyword)
                ->get();
            $likes = $user->likedItems()
                ->ItemSearch($request->keyword)
                ->get();
            return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->ItemSearch($request->keyword)->get();
            return view('index',compact('items'));
        }
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('detail',compact('item'));
    }
}
