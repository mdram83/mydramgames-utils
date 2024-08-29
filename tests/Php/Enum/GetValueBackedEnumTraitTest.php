<?php

namespace Tests\Php\Enum;

use PHPUnit\Framework\TestCase;
use Tests\TestingStubs\BackedEnum;

class GetValueBackedEnumTraitTest extends TestCase
{
    public function testGetValue(): void
    {
        $this->assertEquals(BackedEnum::One->value, BackedEnum::One->getValue());
        $this->assertEquals(BackedEnum::Two->value, BackedEnum::Two->getValue());
    }
}