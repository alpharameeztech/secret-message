<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'sender_id',
        'recipient_id',
        'encrypted_message',
        'expires_at',
        'opened_at',
    ];
}
