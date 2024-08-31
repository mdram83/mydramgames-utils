<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRank;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRankRepository;
use MyDramGames\Utils\Exceptions\PlayingCardException;

class PlayingCardRankRepositoryGeneric implements PlayingCardRankRepository
{
    /**
     * @throws PlayingCardException
     */
    public function getOne(string $key): PlayingCardRank
    {
        if (!$suit = PlayingCardRankGeneric::tryFrom($key)) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_MISSING_RANK);
        }
        return $suit;
    }
}
