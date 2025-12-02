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
        /* Stripe決済画面からブラウザの戻るボタンで戻った場合、商品の購入をできなくしています。 */

        if(Purchase::where('item_id',$request->item_id)->exists()){
            $item = Item::find($request->item_id);

            return redirect()->route('item.order',['item' => $item])->withErrors(['sold' => 'この商品はすでに購入済みです']);
        }

        /* purchasesテーブルに購入情報を保存するための記述です。 */

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

        /* 以下はStripeのテスト決済画面に遷移する記述ですが、
        テスト環境につき、ウェブフックを使用したテーブル操作は設定していません。
        (決済の実行・キャンセルにかかわらず、遷移した時点でpurchasesテーブルに
        レコードは保存されます)
         */

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $itemData = Item::findOrFail($request->item_id);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' =>[[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $itemData->name,
                    ],
                    'unit_amount' => 1000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url,303);
    }

    public function success()
    {
        return redirect()->route('item.index')->with('success','商品の購入が完了しました');
    }

        public function cancel()
    {
        /* 決済をキャンセルしてもpurchasesテーブルにはレコードが作成され、商品にSOLD表示が付きます。 */

        return redirect()->route('item.index');
    }

}
