<?php

use App\Contract\Messaging\ClientContract;
use App\DTOs\Messaging\ClientRecipient;
use App\VOs\Messaging\Content;
use App\VOs\Messaging\PhoneNumber;
use App\DTOs\Messaging\ClientResponse;

it('can send a client recipient', function () {
    $content = new Content('Hello world!');
    $phoneNumber = new PhoneNumber('1234567890');
    $clientRecipient = new ClientRecipient($content, $phoneNumber);

    $mockClient = Mockery::mock(ClientContract::class);
    $mockClient->shouldReceive('send')
        ->with($clientRecipient)
        ->once()
        ->andReturn(Mockery::mock(ClientResponse::class)); // Mock the ClientResponse if needed

    $response = $mockClient->send($clientRecipient);

    $this->assertInstanceOf(ClientResponse::class, $response);
});

it('can convert ClientRecipient to array', function () {
    $content = new Content('Hello world!');
    $phoneNumber = new PhoneNumber('1234567890');
    $clientRecipient = new ClientRecipient($content, $phoneNumber);

    $array = $clientRecipient->toArray();

    $this->assertArrayHasKey('content', $array);
    $this->assertArrayHasKey('to', $array);
    $this->assertEquals('Hello world!', $array['content']);
    $this->assertEquals('1234567890', $array['to']);
});
