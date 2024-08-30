<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\PlayingCardDealer;

class PlayingCardDealerGeneric implements PlayingCardDealer
{

    /**
     * @inheritDoc
     */
    public function dealCards(
        PlayingCardCollection $stock,
        DealDefinitionCollection $definitions,
        bool $shuffleStock = true
    ): void {
        // TODO: Implement dealCards() method.
    }

    /**
     * @inheritDoc
     */
    public function moveCardsByKeys(PlayingCardCollection $fromStock, PlayingCardCollection $toStock, array $keys): void
    {
        // TODO: Implement moveCardsByKeys() method.
    }

    /**
     * @inheritDoc
     */
    public function moveCardsTimes(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        ?int $numberOfCards = null,
    ): void {
        // TODO: Implement moveCardsTimes() method.
    }

    /**
     * @inheritDoc
     */
    public function collectCards(
        PlayingCardCollection $toStock,
        PlayingCardStocksCollection $fromStocks
    ): PlayingCardCollection {
        // TODO: Implement collectCards() method.
    }
}