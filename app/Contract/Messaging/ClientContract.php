<?php

namespace App\Contract\Messaging;

use App\DTOs\Messaging\ClientRecipient;
use App\DTOs\Messaging\ClientResponse;

interface ClientContract
{
    public function send(ClientRecipient $dto): ClientResponse;
}
