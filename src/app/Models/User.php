<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()   //  1人のユーザーは1つのプロフィール情報を持つ。1対1
    {
        return $this->hasOne(Profile::class);
    }

    public function likedItems()    //  いいねしている商品ID取得用のリレーション。多対多
    {
        return $this->belongsToMany(Item::class,'likes','user_id','item_id');
    }

    public function purchasedItems()    //  これ、、、いらないかな？
    {
        return $this->belongsToMany(Item::class,'purchases','user_id','item_id');
    }

    public function comments()  //  1人のユーザーは複数のコメントを投稿する。1対多
    {
        return $this->hasMany(Comment::class);
    }
}
