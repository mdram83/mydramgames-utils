<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardFactory
{
    /**
     * Returns instance of PlayingCard based on predefined PlayingCard key, available in the implementation
     * @param string $key
     * @return PlayingCard
     */
    public function create(string $key): PlayingCard;
}
