<?php

namespace App\VOs;

abstract class BaseValueObject
{
    abstract function getValue();

    public function equals(self $object): bool
    {
        return $this->getValue() === $object->getValue();
    }
}
