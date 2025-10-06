<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $profile = $request->only([
            'user_id',
            'postal_code',
            'address',
            'building',
            'image'
        ]);
        Profile::updateOrCreate([
            'user_id' => $profile['user_id'],
            'user_id' => $profile['user_id'],
            'user_id' => $profile['user_id'],
            'user_id' => $profile['user_id'],
            'user_id' => $profile['user_id']
            ]
        )
    }
}
