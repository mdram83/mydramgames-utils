<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\DealDefinitionItemGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardDealerGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollectionPoweredUnique;
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

        $card1 = $this->createMock(PlayingCard::class);
        $card2 = $this->createMock(PlayingCard::class);
        $card1->method('getKey')->willReturn('key-1');
        $card2->method('getKey')->willReturn('key-2');

        $this->stock = new PlayingCardCollectionPoweredUnique(null, [$card1, $card2]);
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

    public function testGetNumberOfPendingCardsInitialNumber(): void
    {
        $this->assertEquals($this->numberOfCards, $this->dealDefinition->getNumberOfPendingCards());
    }

    public function testGetNumberOfPendingCardsInitialNull(): void
    {
        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, null);
        $this->assertNull($this->dealDefinition->getNumberOfPendingCards());
    }

    public function testCardAndUpdatePendingCounterThrowExceptionWhenInitialZero(): void
    {
        $this->expectException(DealDefinitionItemException::class);
        $this->expectExceptionMessage(DealDefinitionItemException::MESSAGE_NOT_EXPECTED_CARD);

        $card = $this->createMock(PlayingCard::class);
        $card->method('getKey')->willReturn('key-3');

        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, 0);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card);
    }

    public function testCardAndUpdatePendingCounterThrowExceptionWhenMovingBeyondZero(): void
    {
        $this->expectException(DealDefinitionItemException::class);
        $this->expectExceptionMessage(DealDefinitionItemException::MESSAGE_NOT_EXPECTED_CARD);

        $card3 = $this->createMock(PlayingCard::class);
        $card3->method('getKey')->willReturn('key-3');
        $card4 = $this->createMock(PlayingCard::class);
        $card4->method('getKey')->willReturn('key-4');

        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, 1);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card3);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card4);
    }

    public function testCardAndUpdatePendingCounterForNumber(): void
    {
        $card3 = $this->createMock(PlayingCard::class);
        $card3->method('getKey')->willReturn('key-3');

        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, 1);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card3);

        $this->assertEquals(3, $this->stock->count());
        $this->assertEquals(0, $this->dealDefinition->getNumberOfPendingCards());
    }

    public function testCardAndUpdatePendingCounterForNull(): void
    {
        $card3 = $this->createMock(PlayingCard::class);
        $card3->method('getKey')->willReturn('key-3');
        $card4 = $this->createMock(PlayingCard::class);
        $card4->method('getKey')->willReturn('key-4');

        $this->dealDefinition = new DealDefinitionItemGeneric($this->stock, null);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card3);
        $this->dealDefinition->takeCardAndUpdatePendingCounter($card4);

        $this->assertEquals(4, $this->stock->count());
        $this->assertNull($this->dealDefinition->getNumberOfPendingCards());
    }
}
