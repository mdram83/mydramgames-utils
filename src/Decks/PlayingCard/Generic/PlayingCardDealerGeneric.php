<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\DealDefinitionCollection;
use MyDramGames\Utils\Decks\PlayingCard\Support\PlayingCardDealer;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Exceptions\PlayingCardCollectionException;
use MyDramGames\Utils\Exceptions\PlayingCardDealerException;

class PlayingCardDealerGeneric implements PlayingCardDealer
{
    /**
     * @param PlayingCardCollection $deck
     * @param DealDefinitionCollection $definitions
     * @param bool $shuffleDeck
     * @param bool $dealOneCardPerDefinition
     * @inheritDoc
     * @throws PlayingCardDealerException
     * @throws CollectionException
     */
    public function dealCards(
        PlayingCardCollection $deck,
        DealDefinitionCollection $definitions,
        bool $shuffleDeck = true,
        bool $dealOneCardPerDefinition = true
    ): void {
        $this->validateDefinitionsNotEmpty($deck, $definitions);
        $this->validateEnoughCardsInStock($deck, $definitions->getSumNumberOfCards());

        if ($shuffleDeck) {
            $deck->shuffle();
        }

        if ($dealOneCardPerDefinition) {
            $this->dealOneCardPerDefinition($deck, $definitions);
        } else {
            $this->dealAllCardsPerDefinition($deck, $definitions);
        }

        $this->dealRemainingCards($deck, $definitions);
    }

    /**
     * @inheritDoc
     * @throws PlayingCardDealerException|PlayingCardCollectionException
     * @throws CollectionException
     */
    public function moveCardsByKeys(PlayingCardCollection $fromStock, PlayingCardCollection $toStock, array $keys): void
    {
        if ($fromStock->countMatchingKeysCombinations([$keys]) <= 0) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_KEY_MISSING_IN_STOCK);
        }
        foreach ($keys as $key) {
            $toStock->add($fromStock->pull($key));
        }
    }

    /**
     * @inheritDoc
     * @throws PlayingCardDealerException
     * @throws CollectionException
     */
    public function moveCardsTimes(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        int $numberOfCards,
    ): void {
        $this->validateEnoughCardsInStock($fromStock, $numberOfCards);
        for ($i = 1; $i <= $numberOfCards; $i++) {
            $toStock->add($fromStock->pullFirst());
        }
    }

    /**
     * @inheritDoc
     * @throws CollectionException
     * @throws PlayingCardDealerException
     */
    public function collectCards(
        PlayingCardCollection $toStock,
        PlayingCardStocksCollection $fromStocks
    ): PlayingCardCollection {
        foreach ($fromStocks->toArray() as $fromStock) {
            $this->moveCardsTimes($fromStock, $toStock, $fromStock->count());
        }
        return $toStock;
    }

    /**
     * @throws PlayingCardDealerException
     */
    protected function validateDefinitionsNotEmpty(
        PlayingCardCollection $deck,
        DealDefinitionCollection $definitions
    ): void
    {
        if ($definitions->isEmpty()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_DISTRIBUTION_DEFINITION);
        }
    }

    /**
     * @throws PlayingCardDealerException
     */
    protected function validateEnoughCardsInStock(PlayingCardCollection $stock, int $requestedNumberOfCards): void
    {
        if ($requestedNumberOfCards > $stock->count()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_NOT_ENOUGH_IN_STOCK);
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealAllCardsPerDefinition(PlayingCardCollection $deck, DealDefinitionCollection $definitions): void
    {
        foreach ($definitions->toArray() as $definitionItem) {
            while ($definitionItem->getNumberOfPendingCards() > 0) {
                $definitionItem->takeCardAndUpdatePendingCounter($deck->pullFirst());
            }
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealOneCardPerDefinition(PlayingCardCollection $deck, DealDefinitionCollection $definitions): void
    {
        if ($requestedGoesTo = $definitions->filter(fn($item) => $item->getNumberOfCards() > 0)->toArray()) {

            $remainingRequestedCards = $definitions->getSumNumberOfCards();

            while ($remainingRequestedCards > 0) {

                $current = current($requestedGoesTo);

                if ($current->getNumberOfPendingCards() > 0) {
                    $current->takeCardAndUpdatePendingCounter($deck->pullFirst());
                    $remainingRequestedCards--;
                }
                if (!next($requestedGoesTo)) {
                    reset($requestedGoesTo);
                }
            }
        }
    }

    /**
     * @throws CollectionException
     */
    protected function dealRemainingCards(PlayingCardCollection $deck, DealDefinitionCollection $definitions): void
    {
        if ($remainingGoesTo = $definitions->filter(fn($item) => $item->getNumberOfCards() === null)->toArray()) {
            while ($deck->count() > 0) {
                current($remainingGoesTo)->takeCardAndUpdatePendingCounter($deck->pullFirst());
                if (!next($remainingGoesTo)) {
                    reset($remainingGoesTo);
                }
            }
        }
    }
}