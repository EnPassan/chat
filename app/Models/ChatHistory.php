<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $fillable = ['author', 'user_id', 'message_body'];
}
