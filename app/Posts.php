<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable=[
        "user_id", "description", "image_url",
    ];
}
