<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;

/**
 * Provide information how many cards should be dealt for specific stock
 */
interface DealDefinitionItem
{
    /**
     * @return PlayingCardCollection
     */
    public function getStock(): PlayingCardCollection;

    /**
     * Setting number of cards to zero should result in distributing all remaining cards to such stocks one by one.
     * Returned number should be zero or more. Negative number of cards should not be accepted and returned.
     * @return int
     */
    public function getNumberOfCards(): int;
}