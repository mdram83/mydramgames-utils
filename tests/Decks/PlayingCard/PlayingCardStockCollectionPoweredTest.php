<?php

namespace Tests\Decks\PlayingCard;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStockCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class PlayingCardStockCollectionPoweredTest extends TestCase
{
    private PlayingCardCollection $itemOne;
    private PlayingCardCollection $itemTwo;
    private PlayingCardStockCollectionPowered $collection;

    public function setUp(): void
    {
        $this->itemOne = $this->createMock(PlayingCardCollection::class);
        $this->itemTwo = $this->createMock(PlayingCardCollection::class);
        $this->collection = new PlayingCardStockCollectionPowered(null, [$this->itemOne, $this->itemTwo]);
    }

    public function testAddThrowExceptionForSameDefinitionAddedTwice(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->itemOne);
    }

    public function testConstructor(): void
    {
        $this->assertEquals(2, $this->collection->count());
    }
}
