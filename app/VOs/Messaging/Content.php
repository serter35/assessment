<?php

namespace App\VOs\Messaging;

use App\VOs\BaseValueObjectAsString;
use Illuminate\Support\Str;

class Content extends BaseValueObjectAsString
{
    /**
     * Content alanının boş olmaması ve 255 karakter üzerinde olmaması kontrol edildi.
     *
     * @return void
     * @throws \Throwable
     */
    public function validate($value): void
    {
        throw_if(
            empty($value),
            new \InvalidArgumentException('Message content cannot be empty.')
        );

        throw_if(
            Str::length($value) > 255,
            new \InvalidArgumentException('Message content cannot be longer than 255 characters.')
        );
    }
}
