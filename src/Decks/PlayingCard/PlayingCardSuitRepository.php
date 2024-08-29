<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardSuitRepository
{
    /**
     * @param string $key
     * @return PlayingCardSuit
     */
    public function getOne(string $key): PlayingCardSuit;
}
