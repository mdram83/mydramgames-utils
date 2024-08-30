<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionItem;
use MyDramGames\Utils\Exceptions\DealDefinitionItemException;

class DealDefinitionItemGeneric implements DealDefinitionItem
{
    /**
     * Expects not negative $numberOfCards
     * @param PlayingCardCollection $stock
     * @param int $numberOfCards
     * @throws DealDefinitionItemException
     */
    public function __construct(protected PlayingCardCollection $stock, protected int $numberOfCards)
    {
        if ($this->numberOfCards < 0) {
            throw new DealDefinitionItemException(DealDefinitionItemException::MESSAGE_NEGATIVE_NO_OF_CARDS);
        }
    }

    /**
     * @inheritDoc
     */
    public function getStock(): PlayingCardCollection
    {
        return $this->stock;
    }

    /**
     * @inheritDoc
     */
    public function getNumberOfCards(): int
    {
        return $this->numberOfCards;
    }
}