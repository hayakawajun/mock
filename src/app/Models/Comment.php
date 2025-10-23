<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);   //  ユーザーにより複数のコメントが投稿される。usersの従リレーション。
    }
}
