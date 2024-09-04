<?php

namespace MyDramGames\Utils\Php\Enum;

use MyDramGames\Utils\Exceptions\BackedEnumException;

trait FromValueBackedEnumTrait
{
    /**
     * @throws BackedEnumException
     */
    public static function fromValue(int|string|null $value): static
    {
        try {
            return static::from($value);
        } catch (\ValueError) {
            throw new BackedEnumException(BackedEnumException::MESSAGE_MISSING_VALUE, $value);
        }

    }
}
