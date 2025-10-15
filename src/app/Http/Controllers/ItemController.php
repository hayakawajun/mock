<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $loginUser = Auth::id();

        if($loginUser){
            $items = Item::where('user_id','!=',$loginUser)->get();
        }else{
            $items = Item::all();
        }

        return view('index',compact('items'));
    }
}
