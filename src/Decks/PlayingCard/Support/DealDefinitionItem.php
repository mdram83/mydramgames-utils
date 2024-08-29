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
     * @return int
     */
    public function getNumberOfCards(): int;
}