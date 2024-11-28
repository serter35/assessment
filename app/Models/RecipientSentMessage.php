<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipientSentMessage extends Model
{
    protected $fillable = [
        'recipient_id',
        'message_id',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }
}
