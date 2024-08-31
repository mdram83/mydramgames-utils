<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRank;

enum PlayingCardRankGeneric: string implements PlayingCardRank
{
    case One = '1';
    case Two = '2';
    case Three = '3';
    case Four = '4';
    case Five = '5';
    case Six = '6';
    case Seven = '7';
    case Eight = '8';
    case Nine = '9';
    case Ten = '10';
    case Jack = 'J';
    case Queen = 'Q';
    case King = 'K';
    case Ace = 'A';
    case Joker = 'Joker';

    public function getKey(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isJoker(): bool
    {
        return $this->value === 'Joker';
    }
}
