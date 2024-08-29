<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardDeckProvider
{
    /**
     * Generates and returns game specific deck (e.g. 24 cards, 52 cards etc.). Implement as required by your games.
     * @return PlayingCardCollection
     */
    public function getDeck(): PlayingCardCollection;
}
