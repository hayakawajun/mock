<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;


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
            $items = Item::all();
            return view('index',compact('items'));
        }
    }
}
