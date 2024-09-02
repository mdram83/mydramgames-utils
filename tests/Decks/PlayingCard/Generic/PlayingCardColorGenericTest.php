<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardColorGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardColor;
use PHPUnit\Framework\TestCase;

class PlayingCardColorGenericTest extends TestCase
{
    public function testInterfaceInstance(): void
    {
        $this->assertInstanceOf(PlayingCardColor::class, PlayingCardColorGeneric::Red);
    }

    public function testGetName(): void
    {
        $color = PlayingCardColorGeneric::Red;
        $this->assertEquals($color->name, $color->getName());
    }

    public function testDefinition(): void
    {
        $colors = array_map(fn($color) => $color->getName(), PlayingCardColorGeneric::cases());
        $this->assertEquals(['Red', 'Black'], $colors);
    }
}
