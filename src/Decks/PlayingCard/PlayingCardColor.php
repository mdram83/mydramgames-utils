<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

interface PlayingCardColor
{
    /**
     * Returns name of the color (e.g. red, black)
     * @return string
     */
    public function getName(): string;
}
