<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['slug','video','name_video','description','order','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
