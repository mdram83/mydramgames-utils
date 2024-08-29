<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCard
{
    /**
     * Key of the card, may be a combination of Rank and Suit keys. Should be unique across implementation.
     * @return string
     */
    public function getKey(): string;

    /**
     * @return PlayingCardRank
     */
    public function getRank(): PlayingCardRank;

    /**
     * Suit of the specific card. May but null, e.g. for Jokers
     * @return PlayingCardSuit|null
     */
    public function getSuit(): ?PlayingCardSuit;

    /**
     * @return PlayingCardColor
     */
    public function getColor(): PlayingCardColor;
}
