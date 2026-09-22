<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    public const SENDER_CUSTOMER = 'customer';

    public const SENDER_ADMIN = 'admin';

    protected $fillable = [
        'chat_id',
        'sender',
        'message',
        'read_by_customer',
        'read_by_admin',
    ];

    protected $casts = [
        'read_by_customer' => 'boolean',
        'read_by_admin' => 'boolean',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function getSenderLabelAttribute(): string
    {
        return $this->sender === self::SENDER_ADMIN ? 'Admin Mahligai Bakery' : 'Anda';
    }
}
