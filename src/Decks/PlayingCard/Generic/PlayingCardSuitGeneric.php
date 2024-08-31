<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;


use MyDramGames\Utils\Decks\PlayingCard\PlayingCardColor;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuit;

enum PlayingCardSuitGeneric: string implements PlayingCardSuit
{
    case Hearts = 'H';
    case Diamonds = 'D';
    case Clubs = 'C';
    case Spades = 'S';

    public function getKey(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): PlayingCardColor
    {
        return match($this) {
            PlayingCardSuitGeneric::Hearts, PlayingCardSuitGeneric::Diamonds => PlayingCardColorGeneric::Red,
            PlayingCardSuitGeneric::Clubs, PlayingCardSuitGeneric::Spades => PlayingCardColorGeneric::Black,
        };
    }
}
