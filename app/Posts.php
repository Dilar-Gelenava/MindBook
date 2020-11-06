<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable=[
        "user_id", "title", "description", "image_url",
    ];
}
