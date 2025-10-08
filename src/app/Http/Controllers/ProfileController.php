<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
            $imageName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('image',$imageName,'public');
            $profile->image = $path;
        }

        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');

        $profile->save();

        return redirect('/profile')->with('success','プロフィールが更新されました');
    }
}