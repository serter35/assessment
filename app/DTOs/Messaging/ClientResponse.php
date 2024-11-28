<?php

namespace App\DTOs\Messaging;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;

class ClientResponse implements Arrayable
{
    public function __construct(
        public string $messageId,
        public Carbon $sentAt,
    )
    {
    }

    public static function fromHTTPClientResponse(Response $response): static
    {
        return new static(
            $response->json('messageId'),
            $response->json('sentAt', now()),
        );
    }

    public function toArray(): array
    {
        return [
            'messageId' => $this->messageId,
            'sentAt' => $this->sentAt->toDateTimeString(),
        ];
    }
}
