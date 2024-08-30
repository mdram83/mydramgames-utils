<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\DealDefinitionItemGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardDealerGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollectionPoweredUnique;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionCollectionPowered;
use MyDramGames\Utils\Exceptions\PlayingCardDealerException;
use PHPUnit\Framework\TestCase;

class PlayingCardDealerGenericTest extends TestCase
{
    private PlayingCardDealerGeneric $dealer;
    private PlayingCardCollection $deck;
    private PlayingCardCollection $handOne;
    private PlayingCardCollection $handTwo;
    private PlayingCardCollection $handThree;
    private PlayingCardCollection $bonus;
    private int $deckSize = 24;

    public function setUp(): void
    {
        $this->dealer = new PlayingCardDealerGeneric();
        $this->handOne = new PlayingCardCollectionPoweredUnique();
        $this->handTwo = new PlayingCardCollectionPoweredUnique();
        $this->handThree = new PlayingCardCollectionPoweredUnique();
        $this->bonus = new PlayingCardCollectionPoweredUnique();

        $this->deck = new PlayingCardCollectionPoweredUnique();
        for ($i = 1; $i <= $this->deckSize; $i++) {
            $card = $this->createMock(PlayingCard::class);
            $card->method('getKey')->willReturn("key-$i");
            $this->deck->add($card);
        }
    }

    public function testDealCardsThrowExceptionWithEmptyDistributionDefinition(): void
    {
        $this->expectException(PlayingCardDealerException::class);
        $this->expectExceptionMessage(PlayingCardDealerException::MESSAGE_DISTRIBUTION_DEFINITION);

        $definitions = new DealDefinitionCollectionPowered();
        $this->dealer->dealCards($this->deck, $definitions);
    }

    public function testDealCardsThrowExceptionWithNotEnoughInDeck(): void
    {
        $this->expectException(PlayingCardDealerException::class);
        $this->expectExceptionMessage(PlayingCardDealerException::MESSAGE_NOT_ENOUGH_TO_DEAL);

        $definitionItem = new DealDefinitionItemGeneric($this->handOne, $this->deckSize + 1);
        $definitions = new DealDefinitionCollectionPowered(null, [$definitionItem]);
        $this->dealer->dealCards($this->deck, $definitions);
    }

    public function testDealCardsWithoutShuffle(): void
    {
        $deckKeys = $this->deck->keys();

        $definitionItem = new DealDefinitionItemGeneric($this->handOne, $this->deckSize);
        $definitions = new DealDefinitionCollectionPowered(null, [$definitionItem]);
        $this->dealer->dealCards($this->deck, $definitions, false);

        $this->assertSame($deckKeys, $this->handOne->keys());
    }

    public function testDealCardsWithShuffle(): void
    {
        $deckKeys = $this->deck->keys();

        $definitionItem = new DealDefinitionItemGeneric($this->handOne, $this->deckSize);
        $definitions = new DealDefinitionCollectionPowered(null, [$definitionItem]);
        $this->dealer->dealCards($this->deck, $definitions, true);

        $this->assertNotSame($deckKeys, $this->handOne->keys());
    }

    public function testDealCardsSchnapsenDefinition(): void
    {
        $definitionItems = [
            new DealDefinitionItemGeneric($this->handOne, 7),
            new DealDefinitionItemGeneric($this->handTwo, 7),
            new DealDefinitionItemGeneric($this->handThree, 7),
            new DealDefinitionItemGeneric($this->bonus, 3),
        ];
        $definitions = new DealDefinitionCollectionPowered(null, $definitionItems);
        $this->dealer->dealCards($this->deck, $definitions);

        $this->assertEquals(7, $this->handOne->count());
        $this->assertEquals(7, $this->handTwo->count());
        $this->assertEquals(7, $this->handThree->count());
        $this->assertEquals(3, $this->bonus->count());
        $this->assertEquals(0, $this->deck->count());
    }

    public function testDealCardsZeros(): void
    {
        $definitionItems = [
            new DealDefinitionItemGeneric($this->handOne, 0),
            new DealDefinitionItemGeneric($this->handTwo, 0),

        ];
        $definitions = new DealDefinitionCollectionPowered(null, $definitionItems);
        $this->dealer->dealCards($this->deck, $definitions);

        $this->assertEquals(12, $this->handOne->count());
        $this->assertEquals(12, $this->handTwo->count());
        $this->assertEquals(0, $this->deck->count());
    }

    public function testDealCardsNumbersAndZerosTogether(): void
    {
        $definitionItems = [
            new DealDefinitionItemGeneric($this->handOne, 7),
            new DealDefinitionItemGeneric($this->handTwo, 0),
            new DealDefinitionItemGeneric($this->handThree, 0),
            new DealDefinitionItemGeneric($this->bonus, 3),
        ];
        $definitions = new DealDefinitionCollectionPowered(null, $definitionItems);
        $this->dealer->dealCards($this->deck, $definitions);

        $this->assertEquals(7, $this->handOne->count());
        $this->assertEquals(7, $this->handTwo->count());
        $this->assertEquals(7, $this->handThree->count());
        $this->assertEquals(3, $this->bonus->count());
        $this->assertEquals(0, $this->deck->count());
    }

    public function testDealCardsAllCardsPerTargetStock(): void
    {
        $definitionItems = [
            new DealDefinitionItemGeneric($this->handOne, 6),
            new DealDefinitionItemGeneric($this->handTwo, 6),
        ];
        $definitions = new DealDefinitionCollectionPowered(null, $definitionItems);
        $this->dealer->dealCards($this->deck, $definitions, false, false);

        $this->assertSame(
            ['key-1', 'key-2', 'key-3', 'key-4', 'key-5', 'key-6'],
            $this->handOne->keys()
        );
        $this->assertSame(
            ['key-7', 'key-8', 'key-9', 'key-10', 'key-11', 'key-12'],
            $this->handTwo->keys()
        );
    }

    public function testDealCardsOneCardPerTargetStock(): void
    {
        $definitionItems = [
            new DealDefinitionItemGeneric($this->handOne, 6),
            new DealDefinitionItemGeneric($this->handTwo, 6),
        ];
        $definitions = new DealDefinitionCollectionPowered(null, $definitionItems);
        $this->dealer->dealCards($this->deck, $definitions, false, true);

        $this->assertSame(
            ['key-1', 'key-3', 'key-5', 'key-7', 'key-9', 'key-11'],
            $this->handOne->keys()
        );
        $this->assertSame(
            ['key-2', 'key-4', 'key-6', 'key-8', 'key-10', 'key-12'],
            $this->handTwo->keys()
        );
    }
}
