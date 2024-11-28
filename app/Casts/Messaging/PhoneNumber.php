<?php

namespace App\Casts\Messaging;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use App\VOs\Messaging\PhoneNumber as ValueObject;

class PhoneNumber implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return ValueObject::fromValue(normalize_phone_number($value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof ValueObject)
            throw new \InvalidArgumentException("Value must be instance of " . ValueObject::class);

        return $value->getValue();
    }
}
