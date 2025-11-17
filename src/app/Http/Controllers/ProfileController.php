<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;   //Itemモデルのインポート、いらないかも？
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProfileController extends Controller
{
    public function index()
    {
            $user = Auth::user();
            $profile = $user->profile;
            $exhibitedItems = $user->exhibitedItems()->with('purchase')->get();
            $purchasedItems = $user->purchasedItems()->get();

            return view('mypage',compact('profile','exhibitedItems','purchasedItems'));
    }


    public function show(){
        $profile = Auth::user()->profile;

        return view('profile',compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        $profile = $user->profile;

        if(!$profile){
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        if($request->hasFile('image')){
            if($profile->image){
                Storage::disk('public')->delete($profile->image);
            }

            $imageFile = $request->file('image');
            $directory = 'profile_image';
            $fileName = uniqid().'.jpg';
            $path = $directory.'/'.$fileName;

            $manager = new ImageManager(new Driver());

            $image = $manager->read($imageFile->getRealPath());
            $image->scale(width: 200);

            $encodedImage = $image->toJpeg();

            Storage::disk('public')->put($path,$encodedImage);

            $profile->image = $path;
        }

        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');

        $profile->save();

        return redirect()->route('profile.show')->with('success','プロフィールが更新されました');
    }
}