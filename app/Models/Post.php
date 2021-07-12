<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   // protected $table = 'my_post';
    use HasFactory;
    protected $table = "posts";
 //   protected $table = "users";
    public function imagePath() {
        //$path = '/storage/images';
        $path = env('IMAGE_PATH');
        $imageFile = $this -> image ?? 'no_img.jpg';
        return $path.$imageFile;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function viewers() {
        //return $this->belongsToMany(User::class,'post_user','post_id','user_id','id','id','users');
        return $this->belongsToMany(User::class);
    }
}
