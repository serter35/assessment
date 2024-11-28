<?php

namespace App\Models;

use App\Casts\Messaging\Content;
use App\Casts\Messaging\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method \Illuminate\Database\Eloquent\Builder whereSent(bool $value)
 */
class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'phone_number',
        'sent'
    ];

    protected $casts = [
        'content' => Content::class,
        'phone_number' => PhoneNumber::class,
        'sent' => 'boolean',
    ];

    public function sentMessage(): HasOne
    {
        return $this->hasOne(RecipientSentMessage::class);
    }
}
