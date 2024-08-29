<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardRank
{
    /**
     * Generates rank key that should be unique across ranks used within specific implementation
     * @return string
     */
    public function getKey(): string;

    /**
     * Generates rank name
     * @return string
     */
    public function getName(): string;

    /**
     * Informs if rank is Joker
     * @return bool
     */
    public function isJoker(): bool;
}
