<?php

namespace App\VOs;

abstract class BaseValueObjectAsString extends BaseValueObject implements \Stringable
{
    abstract public function validate($value): void;

    public readonly string $value;

    public function __construct(string $value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
