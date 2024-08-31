<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionItem;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Exceptions\DealDefinitionItemException;

class DealDefinitionItemGeneric implements DealDefinitionItem
{
    protected ?int $numberOfPendingCards;

    /**
     * Expects not negative $numberOfCards
     * @param PlayingCardCollection $stock
     * @param int|null $numberOfCards
     * @throws DealDefinitionItemException
     */
    public function __construct(protected PlayingCardCollection $stock, protected ?int $numberOfCards = null)
    {
        if ($this->numberOfCards < 0) {
            throw new DealDefinitionItemException(DealDefinitionItemException::MESSAGE_NEGATIVE_NO_OF_CARDS);
        }
        $this->numberOfPendingCards = $this->numberOfCards;
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
    public function getNumberOfCards(): ?int
    {
        return $this->numberOfCards;
    }

    public function getNumberOfPendingCards(): ?int
    {
        return $this->numberOfPendingCards;
    }

    /**
     * @throws DealDefinitionItemException|CollectionException
     */
    public function takeCardAndUpdatePendingCounter(PlayingCard $playingCard): void
    {
        if ($this->numberOfPendingCards === 0) {
            throw new DealDefinitionItemException(DealDefinitionItemException::MESSAGE_NOT_EXPECTED_CARD);
        }
        $this->stock->add($playingCard);

        if ($this->numberOfPendingCards !== null) {
            $this->numberOfPendingCards--;
        }
    }
}