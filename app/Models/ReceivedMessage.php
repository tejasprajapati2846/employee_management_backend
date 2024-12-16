<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedMessage extends Model
{
    use HasFactory;

    protected $table = 'received_messages';
    
    protected $fillable = ['message_id', 'message_body'];
}
