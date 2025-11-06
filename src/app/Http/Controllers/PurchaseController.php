<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\DB;

use Stripe\Stripe;
use Stripe\Checkout\Session;


class PurchaseController extends Controller
{
    public function order(Item $item)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $shippingAddresses = ShippingAddress::where('user_id',$user->id)->get();

        return view('purchase',compact('item','profile','shippingAddresses'));
    }

    public function payment(PurchaseRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $purchaseData = $request->only('item_id','payment',);
            $purchaseData['user_id'] = $user->id;

            if($request->address == 0){
                if($user->profile){
                    $profileData = $user->profile->only(['postal_code','address','building']);
                    $purchaseData = array_merge( $purchaseData,$profileData);
                }
            }else{
                $shippingAddress = ShippingAddress::find($request->address);
                    if($shippingAddress){
                        $shippingAddressData = $shippingAddress->only(['postal_code','address','building']);
                        $purchaseData = array_merge($purchaseData,$shippingAddressData);
                    }
            }
            Purchase::create($purchaseData);
        });

        return redirect()->route('item.index')->with('success','商品の購入が完了しました');
    }

    public function createCheckoutSession(PurchaseRequest $request)
    {
        $user_id = $request->input('user_id');
        $item_id = $request->input('item_id');
        $payment = $request->input('payment');
        $postal_code = $request->input('postal_code');
        $address = $request->input('address');
        $building = $request->input('building');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' =>[[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '商品名',
                    ],
                    'unit_amount' => 1000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'user_id' => $user_id,
                'item_id' => $item_id,
                'payment' => $payment,
                'postal_code' => $postal_code,
                'address' => $address,
                'building' => $building
            ],
        ]);

        return redirect($session->url,303);
    }

    public function success()
    {

        return redirect()->route('item.index');
    }

        public function cancel()
    {

        return redirect()->route('item.index');
    }

}
