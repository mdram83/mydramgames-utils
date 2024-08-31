<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardColorGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardRankGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardSuitGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardColor;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRank;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuit;
use MyDramGames\Utils\Exceptions\PlayingCardException;
use PHPUnit\Framework\TestCase;

class PlayingCardGenericTest extends TestCase
{
    private PlayingCardRank $aceRank;
    private PlayingCardRank $jokerRank;
    private PlayingCardSuit $suit;
    private PlayingCardColor $color;

    public function setUp(): void
    {
        parent::setUp();
        $this->aceRank = PlayingCardRankGeneric::Ace;
        $this->jokerRank = PlayingCardRankGeneric::Joker;
        $this->suit = PlayingCardSuitGeneric::Hearts;
        $this->color = PlayingCardColorGeneric::Red;
    }
    public function testNewThrowExceptionJokerWithSuit(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_INCORRECT_PARAMS);

        new PlayingCardGeneric($this->jokerRank, $this->suit, $this->color);
    }

    public function testNewThrowExceptionJokerWithoutColor(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_INCORRECT_PARAMS);

        new PlayingCardGeneric($this->jokerRank, null, null);
    }

    public function testNewThrowExceptionNonJokerWithoutSuit(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_INCORRECT_PARAMS);

        new PlayingCardGeneric($this->aceRank, null, null);
    }

    public function testNewThrowExceptionNonJokerWithColor(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_INCORRECT_PARAMS);

        new PlayingCardGeneric($this->aceRank, $this->suit, $this->color);
    }

    public function testJokerCreated(): void
    {
        $card = new PlayingCardGeneric($this->jokerRank, null, $this->color);
        $this->assertInstanceOf(PlayingCard::class, $card);
    }

    public function testNonJokerCreated(): void
    {
        $card = new PlayingCardGeneric($this->aceRank, $this->suit, null);
        $this->assertInstanceOf(PlayingCard::class, $card);
    }

    public function testGetKeyJoker(): void
    {
        $card = new PlayingCardGeneric($this->jokerRank, null, $this->color);
        $jokerKey =
            $this->jokerRank->getKey()
            . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR
            . $this->color->getName();

        $this->assertEquals($jokerKey, $card->getKey());
    }

    public function testGetKeyNonJoker(): void
    {
        $card = new PlayingCardGeneric($this->aceRank, $this->suit);
        $nonJokerKey =
            $this->aceRank->getKey()
            . PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR
            . $this->suit->getKey();

        $this->assertEquals($nonJokerKey, $card->getKey());
    }

    public function testGetRank(): void
    {
        $card = new PlayingCardGeneric($this->aceRank, $this->suit);
        $this->assertEquals($this->aceRank, $card->getRank());
    }

    public function testGetSuitJokerNull(): void
    {
        $card = new PlayingCardGeneric($this->jokerRank, null, $this->color);
        $this->assertNull($card->getSuit());
    }

    public function testGetSuitNonJoker(): void
    {
        $card = new PlayingCardGeneric($this->aceRank, $this->suit);
        $this->assertEquals($this->suit, $card->getSuit());
    }

    public function testGetColorJoker(): void
    {
        $card = new PlayingCardGeneric($this->jokerRank, null, $this->color);
        $this->assertEquals($this->color, $card->getColor());
    }

    public function testColorNonJoker(): void
    {
        $card = new PlayingCardGeneric($this->aceRank, $this->suit);
        $this->assertEquals($this->suit->getColor(), $card->getColor());
    }
}
