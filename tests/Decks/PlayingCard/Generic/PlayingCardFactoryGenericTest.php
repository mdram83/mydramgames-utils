<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardColorGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardFactoryGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardRankGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardSuitGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardFactory;
use MyDramGames\Utils\Exceptions\PlayingCardException;
use PHPUnit\Framework\TestCase;

class PlayingCardFactoryGenericTest extends TestCase
{
    private PlayingCardFactoryGeneric $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new PlayingCardFactoryGeneric();
    }
    public function testInterfaceInstance(): void
    {
        $this->assertInstanceOf(PlayingCardFactory::class, $this->factory);
    }

    public function testThrowExceptionIncorrectRank(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_MISSING_RANK);

        $key = '21' . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR . PlayingCardSuitGeneric::Hearts->getKey();
        $this->factory->create($key);
    }

    public function testThrowExceptionJokerIncorrectColor(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_MISSING_COLOR);

        $key = PlayingCardRankGeneric::Joker->getKey() . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR . 'Rainy';
        $this->factory->create($key);
    }

    public function testThrowExceptionNonJokerIncorrectSuit(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_MISSING_SUIT);

        $key = PlayingCardRankGeneric::Ace->getKey() . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR . 'HeartsAndFires';
        $this->factory->create($key);
    }

    public function testCreateJoker(): void
    {
        $key =
            PlayingCardRankGeneric::Joker->getKey()
            . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR
            . PlayingCardColorGeneric::Red->getName();
        $card = $this->factory->create($key);

        $this->assertInstanceOf(PlayingCard::class, $card);
        $this->assertEquals($key, $card->getKey());
    }

    public function testCreateNonJoker(): void
    {
        $key =
            PlayingCardRankGeneric::Ace->getKey()
            . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR
            . PlayingCardSuitGeneric::Hearts->getKey();
        $card = $this->factory->create($key);

        $this->assertInstanceOf(PlayingCard::class, $card);
        $this->assertEquals($key, $card->getKey());
    }
}
