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
        return $this->belongsToMany(Category::class,'item_category','item_id','category_id')
                    ->withTimestamps();
    }

    public function likers()
    {
        return $this->belongsToMany(User::class,'likes','item_id','user_id');
    }

        public function purchasers()
    {
        return $this->belongsToMany(User::class,'purchases','item_id','user_id');
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeItemSearch($query,$keywords)
    {
        if(!$keywords){
            return $query;
        }

        $keywords = trim($keywords);
        $keyword_array = preg_split('/[\\s]+/u',$keywords, -1, PREG_SPLIT_NO_EMPTY);

        foreach($keyword_array as $keyword){
            $query->where('name','LIKE',"%{$keyword}%");
        }

        return $query;
    }
}