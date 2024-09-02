<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardColorGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardSuitGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuit;
use PHPUnit\Framework\TestCase;

class PlayingCardSuitGenericTest extends TestCase
{
    public function testInterfaceInstance(): void
    {
        $suit = PlayingCardSuitGeneric::Hearts;
        $this->assertInstanceOf(PlayingCardSuit::class, $suit);
    }

    public function testGetKey(): void
    {
        $suit = PlayingCardSuitGeneric::Hearts;
        $this->assertEquals($suit->value, $suit->getKey());
    }

    public function testGetName(): void
    {
        $suit = PlayingCardSuitGeneric::Hearts;
        $this->assertEquals($suit->name, $suit->getName());
    }

    public function testGetColor(): void
    {
        $suit = PlayingCardSuitGeneric::Hearts;
        $this->assertEquals(PlayingCardColorGeneric::Red, $suit->getColor());
    }
}
