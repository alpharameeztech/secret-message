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

     protected $casts = [
        'expires_at' => 'datetime',
        'opened_at' => 'datetime',
    ];


    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
