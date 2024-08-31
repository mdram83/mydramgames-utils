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
        $this->validateDefinitionsNotEmptyAndEnoughCards($deck, $definitions);

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
        PlayingCardCollection $deck,
        DealDefinitionCollection $definitions
    ): void
    {
        if ($definitions->isEmpty()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_DISTRIBUTION_DEFINITION);
        }

        if ($definitions->getSumNumberOfCards() > $deck->count()) {
            throw new PlayingCardDealerException(PlayingCardDealerException::MESSAGE_NOT_ENOUGH_TO_DEAL);
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