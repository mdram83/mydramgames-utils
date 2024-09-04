<?php

namespace MyDramGames\Utils\Php\Enum;

trait FromValueBackedEnumTrait
{
    public static function fromValue(int|string|null $value): static
    {
        return static::from($value);
    }
}
