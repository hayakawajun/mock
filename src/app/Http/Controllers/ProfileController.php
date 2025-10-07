<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function profile(){
        $profile = Profile::where('user_id',Auth::id())->first();
        if($profile){
            return view('profile',compact('profile'));
        }else{
            return view('profile');
        }
    }

    public function update(ProfileRequest $request)
    {
        $userName = $request->only(['name']);
        User::find($request->user_id)->update($userName);

        $data = $request->only(['user_id','postal_code','address','building','image']);

        $data = [
            'user_id' => $request->input('user_id'),
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'image' => $request->input('image')
        ];

        $profile = Profile::updateOrCreate(
            ['id' => $data['user_id']],$data
        );
        return redirect('/');
    }
}
