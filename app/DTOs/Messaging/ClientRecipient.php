<?php

namespace App\DTOs\Messaging;

use App\Models\Recipient;
use App\VOs\Messaging\Content;
use App\VOs\Messaging\PhoneNumber;
use Illuminate\Contracts\Support\Arrayable;

class ClientRecipient implements Arrayable
{
    public function __construct(
        public Content $content,
        public PhoneNumber $to,
    )
    {
    }

    public static function fromModel(Recipient $recipient): static
    {
        return new static(
            $recipient->content,
            $recipient->phone_number,
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content->value,
            'to' => $this->to->value,
        ];
    }
}
