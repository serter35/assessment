<?php

use App\VOs\Messaging\Content;
use App\VOs\Messaging\PhoneNumber;
use Tests\TestCase;

uses(TestCase::class);

it('throws an exception if content is empty in ClientRecipient', function () {
    $this->expectException(\InvalidArgumentException::class);
    new Content('');
});

it('throws an exception if content exceeds 255 characters', function () {
    $this->expectException(\InvalidArgumentException::class);
    new Content(str_repeat('a', 256));
});

it('throws an exception if phone number exceeds 15 characters', function () {
    $this->expectException(\InvalidArgumentException::class);
    new PhoneNumber(str_repeat('1', 16));
});
