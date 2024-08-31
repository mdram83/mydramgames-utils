<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuit;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuitRepository;
use MyDramGames\Utils\Exceptions\PlayingCardException;

class PlayingCardSuitRepositoryGeneric implements PlayingCardSuitRepository
{
    /**
     * @throws PlayingCardException
     */
    public function getOne(string $key): PlayingCardSuit
    {
        if (!$suit = PlayingCardSuitGeneric::tryFrom($key)) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_MISSING_SUIT);
        }
        return $suit;
    }
}
