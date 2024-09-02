<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardRankGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRank;
use PHPUnit\Framework\TestCase;

class PlayingCardRankGenericTest extends TestCase
{
    public function testInterfaceInstance(): void
    {
        $rank = PlayingCardRankGeneric::Ace;
        $this->assertInstanceOf(PlayingCardRank::class, $rank);
    }

    public function testGetKay(): void
    {
        $rank = PlayingCardRankGeneric::Ace;
        $this->assertEquals($rank->value, $rank->getKey());
    }

    public function testGetName(): void
    {
        $rank = PlayingCardRankGeneric::Ace;
        $this->assertEquals($rank->name, $rank->getName());
    }

    public function testIsJokerTrue(): void
    {
        $rank = PlayingCardRankGeneric::Joker;
        $this->assertTrue($rank->isJoker());
    }

    public function testIsJokerFalse(): void
    {
        $rank = PlayingCardRankGeneric::Ace;
        $this->assertFalse($rank->isJoker());
    }
}
