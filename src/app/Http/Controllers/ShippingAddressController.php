<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;



class ShippingAddressController extends Controller
{
    public function create(Item $item)
    {
        return view('address_create',compact('item'));
    }

    public function store(AddressRequest $request, Item $item)
    {
        $address = $request->validated();
        $address['user_id'] = Auth::id();
        ShippingAddress::create($address);

        return redirect()->route('item.order',['item' => $item])->with('success','配送先住所を登録しました');
    }

    public function edit(Item $item, ShippingAddress $shippingAddress)
    {
        return view('address_update',compact('item','shippingAddress'));
    }

    public function addressUpdate(AddressRequest $request, Item $item)
    {
        $address = $request->validated();
        $address['user_id'] = Auth::id();
        ShippingAddress::find($request->id)->update($address);

        return redirect()->route('item.order',['item' => $item])->with('success','配送先住所を更新しました');
    }

    public function destroy(Item $item, ShippingAddress $shippingAddress)
    {
        ShippingAddress::find($shippingAddress->id)->delete();

        return redirect()->route('item.order',['item' => $item])->with('success','配送先住所を削除しました');
    }
}
