<?php

namespace MyDramGames\Utils\Php\Enum;

use MyDramGames\Utils\Exceptions\BackedEnumException;

trait FromNameBackedEnumTrait
{
    /**
     * @throws BackedEnumException
     */
    public static function fromName(string $name): static
    {
        try {
            return static::{$name};
        } catch (\Error) {
            throw new BackedEnumException(BackedEnumException::MESSAGE_MISSING_NAME);
        }

    }
}
