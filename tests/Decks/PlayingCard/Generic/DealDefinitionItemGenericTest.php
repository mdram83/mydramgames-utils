<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\DealDefinitionItemGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Exceptions\DealDefinitionItemException;
use PHPUnit\Framework\TestCase;

class DealDefinitionItemGenericTest extends TestCase
{
    private DealDefinitionItemGeneric $dealDefinition;
    private PlayingCardCollection $stock;
    private int $numberOfCards;
    private array $collectionKeys;

    public function setUp(): void
    {
        $this->collectionKeys = ['key-1', 'key-2'];
        $this->stock = $this->createMock(PlayingCardCollection::class);
        $this->stock->method('keys')->willReturn($this->collectionKeys);
        $this->numberOfCards = 2;
        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, $this->numberOfCards);
    }

    public function testConstructorThrowExceptionForNegativeNumberOfCards(): void
    {
        $this->expectException(DealDefinitionItemException::class);
        $this->expectExceptionMessage(DealDefinitionItemException::MESSAGE_NEGATIVE_NO_OF_CARDS);

        $dealDefinition = new DealDefinitionItemGeneric($this->stock, -1);
    }

    public function testGetStock(): void
    {
        $this->assertSame($this->collectionKeys, $this->dealDefinition->getStock()->keys());
    }

    public function testGetNumberOfCards(): void
    {
        $this->assertEquals($this->numberOfCards, $this->dealDefinition->getNumberOfCards());
    }
}
