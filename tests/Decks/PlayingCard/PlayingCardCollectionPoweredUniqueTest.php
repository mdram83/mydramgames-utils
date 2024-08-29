<?php

namespace Tests\Decks\PlayingCard;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollectionPoweredUnique;
use PHPUnit\Framework\TestCase;

class PlayingCardCollectionPoweredUniqueTest extends TestCase
{
    private PlayingCard $cardOne;
    private PlayingCard $cardTwo;

    public function setUp(): void
    {
        $this->cardOne = $this->createMock(PlayingCard::class);
        $this->cardTwo = $this->createMock(PlayingCard::class);
        $this->cardOne->method('getKey')->willReturn('key-1');
        $this->cardTwo->method('getKey')->willReturn('key-2');
    }

    public function testAdd(): void
    {
        $collection = new PlayingCardCollectionPoweredUnique(null, [$this->cardOne, $this->cardTwo]);
        $this->assertSame([$this->cardOne->getKey(), $this->cardTwo->getKey()], array_keys($collection->toArray()));
    }
}
