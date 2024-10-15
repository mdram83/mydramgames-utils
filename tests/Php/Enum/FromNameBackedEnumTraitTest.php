<?php

namespace Tests\Php\Enum;

use MyDramGames\Utils\Exceptions\BackedEnumException;
use PHPUnit\Framework\TestCase;
use Tests\TestingStubs\BackedEnum;

class FromNameBackedEnumTraitTest extends TestCase
{
    public function testFromValueThrowErrorIfNoValue(): void
    {
        $this->expectException(BackedEnumException::class);
        $this->expectExceptionMessage(BackedEnumException::MESSAGE_MISSING_NAME);

        BackedEnum::fromName('No-such N@me1(&&**');
    }

    public function testFromName(): void
    {
        $backedEnum = BackedEnum::fromName(BackedEnum::One->name);
        $this->assertEquals($backedEnum->value, BackedEnum::One->getValue());
    }
}
