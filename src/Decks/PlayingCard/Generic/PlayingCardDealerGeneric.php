<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\PlayingCardDealer;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Exceptions\PlayingCardDealerException;

class PlayingCardDealerGeneric implements PlayingCardDealer
{
    /**
     * @param PlayingCardCollection $stock
     * @param DealDefinitionCollection $definitions
     * @param bool $shuffleStockPriorToDealing
     * @param bool $dealOneCardPerDefinition
     * @inheritDoc
     * @throws PlayingCardDealerException
     * @throws CollectionException
     */
    public function dealCards(
        PlayingCardCollection $stock,
        DealDefinitionCollection $definitions,
        bool $shuffleStockPriorToDealing = true,
        bool $dealOneCardPerDefinition = true
    ): void {
        $this->validateDefinitionsNotEmptyAndEnoughCards($stock, $definitions);

        if ($shuffleStockPriorToDealing) {
            $stock->shuffle();
        }

        if ($dealOneCardPerDefinition) {
            $this->dealOneCardPerDefinition($stock, $definitions);
        } else {
            $this->dealAllCardsPerDefinition($stock, $definitions);
        }

        $this->dealRemainingCards($stock, $definitions);
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

    /**
     * @throws PlayingCardDealerException
     */
    protected function validateDefinitionsNotEmptyAndEnoughCards(
        PlayingCardCollection $stock,
        DealDefinitionCollection $definitions
    ): void
    {
        if ($definitions->isEmpty()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_DISTRIBUTION_DEFINITION);
        }

        $requestedCards = array_sum(array_map(fn($item) => $item->getNumberOfCards(), $definitions->toArray()));
        if ($requestedCards > $stock->count()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_NOT_ENOUGH_TO_DEAL);
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealAllCardsPerDefinition(PlayingCardCollection $stock, DealDefinitionCollection $definitions): void
    {
        foreach ($definitions->toArray() as $definitionItem) {
            for ($i = 1; $i <= $definitionItem->getNumberOfCards(); $i++) {
                $definitionItem->getStock()->add($stock->pullFirst());
            }
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealOneCardPerDefinition(PlayingCardCollection $stock, DealDefinitionCollection $definitions): void
    {
        if ($requestedGoesTo = $definitions->filter(fn($item) => $item->getNumberOfCards() > 0)->toArray()) {
            $remainingRequestedCards = array_sum(array_map(fn($item) => $item->getNumberOfCards(), $requestedGoesTo));
            while ($remainingRequestedCards > 0) {
                current($requestedGoesTo)->getStock()->add($stock->pullFirst());
                if (!next($requestedGoesTo)) {
                    reset($requestedGoesTo);
                }
                $remainingRequestedCards--;
            }
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealRemainingCards(PlayingCardCollection $stock, DealDefinitionCollection $definitions): void
    {
        if ($remainingGoesTo = $definitions->filter(fn($item) => $item->getNumberOfCards() === 0)->toArray()) {
            while ($stock->count() > 0) {
                current($remainingGoesTo)->getStock()->add($stock->pullFirst());
                if (!next($remainingGoesTo)) {
                    reset($remainingGoesTo);
                }
            }
        }
    }
}