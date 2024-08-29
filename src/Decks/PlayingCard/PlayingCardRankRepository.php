<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardRankRepository
{
    /**
     * @param string $key
     * @return PlayingCardRank
     */
    public function getOne(string $key): PlayingCardRank;
}
