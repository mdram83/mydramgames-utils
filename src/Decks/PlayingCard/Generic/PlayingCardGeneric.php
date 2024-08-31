<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardColor;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRank;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuit;
use MyDramGames\Utils\Exceptions\PlayingCardException;

class PlayingCardGeneric implements PlayingCard
{
    public const string PLAYING_CARD_KEY_SEPARATOR = '-';

    /**
     * @throws PlayingCardException
     */
    public function __construct(
        readonly private PlayingCardRank $rank,
        readonly private ?PlayingCardSuit $suit = null,
        readonly private ?PlayingCardColor $color = null
    )
    {
        $this->validateParams();
    }

    public function getKey(): string
    {
        return
            $this->rank->getKey()
            . self::PLAYING_CARD_KEY_SEPARATOR
            . ($this->rank->isJoker() ? $this->color->getName() : $this->suit->getKey());
    }

    public function getRank(): PlayingCardRank
    {
        return $this->rank;
    }

    public function getSuit(): ?PlayingCardSuit
    {
        return $this->suit;
    }

    public function getColor(): PlayingCardColor
    {
        return $this->rank->isJoker() ? $this->color : $this->suit->getColor();
    }

    /**
     * @throws PlayingCardException
     */
    protected function validateParams(): void
    {
        if (
            ($this->rank->isJoker() && (isset($this->suit) || !isset($this->color)))
            || (!$this->rank->isJoker() && (!isset($this->suit) || isset($this->color)))
        ) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_INCORRECT_PARAMS);
        }
    }
}
