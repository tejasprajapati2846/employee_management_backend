<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentMessage extends Model
{
    use HasFactory;
    
    protected $table = 'sent_messages';

    protected $fillable = ['message_id', 'message_body'];
}
