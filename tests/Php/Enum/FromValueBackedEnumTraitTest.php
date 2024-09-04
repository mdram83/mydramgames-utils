<?php

namespace Tests\Php\Enum;

use PHPUnit\Framework\TestCase;
use Tests\TestingStubs\BackedEnum;
use ValueError;

class FromValueBackedEnumTraitTest extends TestCase
{
    public function testFromValueThrowErrorIfNoValue(): void
    {
        $this->expectException(ValueError::class);
        BackedEnum::fromValue(91919191);
    }

    public function testFromValue(): void
    {
        $backedEnum = BackedEnum::fromValue(BackedEnum::One->value);
        $this->assertEquals($backedEnum->value, BackedEnum::One->getValue());
    }
}
