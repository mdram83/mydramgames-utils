<?php

namespace MyDramGames\Utils\Php\Enum;

trait GetValueBackedEnumTrait
{
    public function getValue(): int|string|null
    {
        return $this->value;
    }
}
