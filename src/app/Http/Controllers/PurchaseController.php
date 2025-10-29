<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function order(Item $item)
    {
        $profile = Auth::user()->profile;

        return view('purchase',compact('item','profile'));
    }

    public function addressEdit(Item $item)
    {
        $profile = Auth::user()->profile;

        return view('address_update',compact('item','profile'));
    }

    public function addressUpdate(Request $request,Item $item)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if(!$profile){
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');

        $profile->save();

        return redirect()->route('item.order',['item' => $item])->with('success','配送先住所を登録しました');
    }

    public function payment(Request $request)
    {
    }
}
