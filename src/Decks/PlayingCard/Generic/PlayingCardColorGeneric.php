<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardColor;

enum PlayingCardColorGeneric implements PlayingCardColor
{
    case Red;
    case Black;

    public function getName(): string
    {
        return $this->name;
    }
}
