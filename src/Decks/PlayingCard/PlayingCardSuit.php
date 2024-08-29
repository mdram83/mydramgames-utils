<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardSuit
{
    /**
     * Key of the Suit that should be unique across specific implementation
     * @return string
     */
    public function getKey(): string;

    /**
     * Name of the Suit (e.g. Spades, Hearts)
     * @return string
     */
    public function getName(): string;

    /**
     * Color assigned to Suit (e.g. Red for Hearts)
     * @return PlayingCardColor
     */
    public function getColor(): PlayingCardColor;
}
