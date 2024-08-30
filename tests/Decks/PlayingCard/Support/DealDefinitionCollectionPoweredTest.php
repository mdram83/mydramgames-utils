<?php

namespace Tests\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionCollectionPowered;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionItem;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class DealDefinitionCollectionPoweredTest extends TestCase
{
    private DealDefinitionItem $definitionOne;
    private DealDefinitionItem $definitionTwo;
    private DealDefinitionCollectionPowered $collection;

    public function setUp(): void
    {
        $this->definitionOne = $this->createMock(DealDefinitionItem::class);
        $this->definitionTwo = $this->createMock(DealDefinitionItem::class);
        $this->collection = new DealDefinitionCollectionPowered(null, [$this->definitionOne, $this->definitionTwo]);
    }

    public function testAddThrowExceptionForSameDefinitionAddedTwice(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->definitionOne);
    }

    public function testAdd(): void
    {
        $this->assertEquals(
            [spl_object_hash($this->definitionOne), spl_object_hash($this->definitionTwo)],
            array_keys($this->collection->toArray())
        );
    }
}
