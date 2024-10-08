<?php

namespace Tests\Decks\PlayingCard;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollectionPoweredUnique;
use MyDramGames\Utils\Exceptions\PlayingCardCollectionException;
use PHPUnit\Framework\TestCase;
use stdClass;

class PlayingCardCollectionPoweredUniqueTest extends TestCase
{
    private PlayingCard $cardOne;
    private PlayingCard $cardTwo;
    private PlayingCardCollectionPoweredUnique $collection;

    public function setUp(): void
    {
        $this->cardOne = $this->createMock(PlayingCard::class);
        $this->cardTwo = $this->createMock(PlayingCard::class);
        $this->cardOne->method('getKey')->willReturn('key-1');
        $this->cardTwo->method('getKey')->willReturn('key-2');
        $this->collection = new PlayingCardCollectionPoweredUnique(null, [$this->cardOne, $this->cardTwo]);
    }

    public function testAdd(): void
    {
        $this->assertSame(
            [$this->cardOne->getKey(), $this->cardTwo->getKey()],
            array_keys($this->collection->toArray())
        );
    }

    public function testCountMatchingKeysCombinationsThrowExceptionOnIncorrectArrayInputStructure(): void
    {
        $this->expectException(PlayingCardCollectionException::class);
        $this->expectExceptionMessage(PlayingCardCollectionException::MESSAGE_INCORRECT_COMBINATION);

        $incorrectKeysCombination = [['key-1', 'key-2'], 'incompatible-not-array-of-keys'];
        $this->collection->countMatchingKeysCombinations($incorrectKeysCombination);
    }

    public function testCountMatchingKeysCombinationsThrowExceptionOnIncorrectArrayInputKeys(): void
    {
        $this->expectException(PlayingCardCollectionException::class);
        $this->expectExceptionMessage(PlayingCardCollectionException::MESSAGE_INCORRECT_COMBINATION);

        $incorrectKeysCombination = [['key-1', 'key-2'], [new stdClass()]];
        $this->collection->countMatchingKeysCombinations($incorrectKeysCombination);
    }

    public function testCountMatchingKeysCombination(): void
    {
        for ($i = 3; $i <= 10; $i++) {
            $extraCard = $this->createMock(PlayingCard::class);
            $extraCard->method('getKey')->willReturn("key-$i");
            $this->collection->add($extraCard);
        }

        $combTrue1 = ['key-1', 'key-2'];
        $combTrue2 = ['key-1', 'key-2', 'key-3', 'key-4', 'key-5', 'key-6', 'key-7', 'key-8', 'key-9', 'key-10'];
        $combFalse1 = ['key-1', 'key-2', 'key-11', 'key-12'];
        $combFalse2 = ['key-11', 'k-12'];

        $this->assertEquals(0, $this->collection->countMatchingKeysCombinations([$combFalse1, $combFalse2]));
        $this->assertEquals(1, $this->collection->countMatchingKeysCombinations([$combTrue1, $combFalse1]));
        $this->assertEquals(2, $this->collection->countMatchingKeysCombinations([$combTrue1, $combTrue2, $combFalse1, $combFalse2]));
    }

    public function testSortByKeysSimple(): void
    {
        $cardThree = $this->createMock(PlayingCard::class);
        $cardThree->method('getKey')->willReturn('key-3');
        $this->collection->add($cardThree);

        $initialCollection = $this->collection->clone();
        $initialKeys = $initialCollection->keys();

        $orderedKeysAll = [$initialKeys[1], $initialKeys[2], $initialKeys[0]];
        $incompleteKeys = [$initialKeys[2]];

        $this->assertSame($orderedKeysAll, $this->collection->sortByKeys($orderedKeysAll)->keys());
        $this->assertSame([$initialKeys[2], $initialKeys[0], $initialKeys[1]], $initialCollection->sortByKeys($incompleteKeys)->keys());
    }

    public function testSortByKeysAdvanced(): void
    {
        $keys  = ['A-H', 'J-D', 'K-D', 'K-C', '9-S', '10-S', 'K-S'];
        $order = ['K-S', 'K-D', 'J-D', '9-S', 'K-C', 'A-H', '10-S'];

        $cardsArray = [];
        foreach ($keys as $key) {
            $card = $this->createMock(PlayingCard::class);
            $card->method('getKey')->willReturn($key);
            $cardsArray[] = $card;
        }

        $cards = new PlayingCardCollectionPoweredUnique(null, $cardsArray);

        $this->assertEquals($order, $cards->sortByKeys($order)->keys());
    }
}
