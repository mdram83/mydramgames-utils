<?php

namespace Tests\Php\Enum;

use MyDramGames\Utils\Exceptions\BackedEnumException;
use PHPUnit\Framework\TestCase;
use Tests\TestingStubs\BackedEnum;
use ValueError;

class FromValueBackedEnumTraitTest extends TestCase
{
    public function testFromValueThrowErrorIfNoValue(): void
    {
        $this->expectException(BackedEnumException::class);
        $this->expectExceptionMessage(BackedEnumException::MESSAGE_MISSING_VALUE);
        BackedEnum::fromValue(91919191);
    }

    public function testFromValue(): void
    {
        $backedEnum = BackedEnum::fromValue(BackedEnum::One->value);
        $this->assertEquals($backedEnum->value, BackedEnum::One->getValue());
    }
}
