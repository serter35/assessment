<?php

namespace App\VOs\Messaging;

use App\VOs\BaseValueObjectAsString;
use Illuminate\Support\Str;

class PhoneNumber extends BaseValueObjectAsString
{
    public function __construct(string $value)
    {
        parent::__construct(normalize_phone_number($value));
    }

    public function validate($value): void
    {
        throw_if(
            Str::length($value) > 15,
            new \InvalidArgumentException('Phone number cannot be longer than 15 characters.')
        );
    }
}
