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

    public function categories()
    {
        return $this->belongsToMany(Category::class,'item_category','item_id','category_id');
    }

    public function likers()
    {
        return $this->belongsToMany(User::class,'likes','item_id','user_id');
    }

        public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function scopeItemSearch($query,$keyword)
    {
        if(!empty($keyword)){
            $query->where('name','like','%'.$keyword.'%');
        }
    }
}
