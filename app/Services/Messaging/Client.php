<?php

namespace App\Services\Messaging;

use App\Contract\Messaging\ClientContract;
use App\DTOs\Messaging\ClientRecipient;
use App\DTOs\Messaging\ClientResponse;
use Illuminate\Support\Facades\Http;

class Client implements ClientContract
{
    public function __construct(
        private readonly string $serviceURL
    )
    {
    }

    public function send(ClientRecipient $dto): ClientResponse
    {
        $response = Http::asJson()->acceptJson()->post($this->serviceURL, $dto->toArray());
        $response->throwUnlessStatus(202);

        return ClientResponse::fromHTTPClientResponse($response);
    }
}
