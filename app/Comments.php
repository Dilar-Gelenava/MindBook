<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable=[
        "user_id", "post_id", "comment",
    ];
}
