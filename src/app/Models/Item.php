<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bland',
        'description',
        'status',
        'price',
        'image'
    ];

    public function likers()
    {
        return $this->belongsToMany(User::class,'likes','item_id','user_id');
    }
}
