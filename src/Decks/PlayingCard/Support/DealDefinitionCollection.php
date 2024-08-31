<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Php\Collection\Collection;

interface DealDefinitionCollection extends Collection
{
    /**
     * Sum number of cards within each definition item
     * @return int
     */
    public function getSumNumberOfCards(): int;
}