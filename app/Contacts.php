<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $fillable=[
        "user_id",
        "contact_id",
        "last_message_id",
    ];
}
