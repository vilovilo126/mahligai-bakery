<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'customer_id',
        'admin_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('id');
    }

    public function latestMessage(): HasMany
    {
        return $this->messages()->latest('id');
    }

    public function unreadByAdmin(): HasMany
    {
        return $this->messages()->where('sender', 'customer')->where('read_by_admin', false);
    }

    public function unreadByCustomer(): HasMany
    {
        return $this->messages()->where('sender', 'admin')->where('read_by_customer', false);
    }
}
