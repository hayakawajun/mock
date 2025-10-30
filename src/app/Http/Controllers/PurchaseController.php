<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;


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

    public function addressUpdate(AddressRequest $request,Item $item)
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

    public function payment(PurchaseRequest $request)
    {
        $purchase = $request->only([
            'user_id',
            'item_id',
            'payment',
            'postal_code',
            'address',
            'building'
        ]);
        Purchase::create($purchase);

        return redirect()->route('item.index')->with('success','商品の購入が完了しました');
    }
}
