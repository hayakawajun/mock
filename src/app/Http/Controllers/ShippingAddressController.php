<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;



class ShippingAddressController extends Controller
{
    public function edit(Item $item, ShippingAddress $shippingAddress)
    {
        return view('shipping_address',compact('item','shippingAddress'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        $address = $request->validated();
        $address['user_id'] = Auth::id();

        if(empty($request->id)){
            ShippingAddress::create($address);
            $message = '配送先住所を登録しました';

        }else{
            ShippingAddress::find($request->id)->update($address);
            $message = '配送先住所を更新しました';
        }

        return redirect()->route('item.order',['item' => $item])->with('success',$message);
    }

    public function destroy(Item $item, ShippingAddress $shippingAddress)
    {
        ShippingAddress::find($shippingAddress->id)->delete();

        return redirect()->route('item.order',['item' => $item])->with('success','配送先住所を削除しました');
    }
}
