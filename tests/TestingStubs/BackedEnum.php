<?php

namespace Tests\TestingStubs;

use MyDramGames\Utils\Php\Enum\FromNameBackedEnumTrait;
use MyDramGames\Utils\Php\Enum\FromValueBackedEnumTrait;
use MyDramGames\Utils\Php\Enum\GetValueBackedEnumTrait;

enum BackedEnum: int
{
    use GetValueBackedEnumTrait;
    use FromValueBackedEnumTrait;
    use FromNameBackedEnumTrait;

    case One = 1;
    case Two = 2;
}
