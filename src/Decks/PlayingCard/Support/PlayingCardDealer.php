<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;

interface PlayingCardDealer
{

    // Not needed, install in dedicated GameServicesProvider to use within specific GamePlay
    // public function getEmptyStock(bool $unique = true): PlayingCardCollection;

    /**
     * Shuffle cards and distribute according to provided definitions. @see DealDefinitionItem for details.
     * @param PlayingCardCollection $stock
     * @param DealDefinitionCollection $definitions
     * @param bool $shuffleStock
     * @return void
     */
    public function dealCards(PlayingCardCollection $stock, DealDefinitionCollection $definitions, bool $shuffleStock = true): void;

    // Not needed, added Collection::keys() method instead.
    // TODO test return types conflicts in first implementation (for this one and below...)
    // public function getCardsByKeys(PlayingCardCollection $deck, array $keys): PlayingCardCollection;

    // Not needed, added Collection::keys() method instead.
    // public function getCardsKeys(PlayingCardCollection $stock): array;

    // TODO 4. move to PlayingCardCollection new method getCardsSortedByKeys(array $keys) that utilize Collection new method sort(callable);
    public function getSortedCards(PlayingCardCollection $stock, array $keys): PlayingCardCollection;

    // Not needed, added Collection::pullFirst() method instead.
    // TODO test return types conflicts in first implementation (for this one and below...)
    // public function pullFirstCard(PlayingCardCollection $stock): ?PlayingCard;


    /**
     * Move cards between the stocks by PlayingCard key
     * @param PlayingCardCollection $fromStock
     * @param PlayingCardCollection $toStock
     * @param array $keys
     * @return void
     */
    public function moveCardsByKeys(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        array $keys
    ): void;

    /**
     * Move cards between stocks provided number of times. $numberOfCards set to null should move all available cards.
     * @param PlayingCardCollection $fromStock
     * @param PlayingCardCollection $toStock
     * @param int|null $numberOfCards
     * @return void
     */
    public function moveCardsTimes(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        ?int $numberOfCards = null,
    ): void;

    /**
     * Collect all cards from collection of stocks to target stock and return target stock
     * @param PlayingCardCollection $toStock
     * @param PlayingCardStocksCollection $fromStocks
     * @return PlayingCardCollection
     */
    public function collectCards(PlayingCardCollection $toStock, PlayingCardStocksCollection $fromStocks): PlayingCardCollection;

    // Not needed, utilize PlayingCardCollection::countMatchingKeyCombinations
    // public function hasStockAnyCombination(PlayingCardCollection $stock, array $combinations): bool;

    // Moved to PlayingCardCollection::countMatchingKeyCombinations
    // public function countStockMatchingCombinations(PlayingCardCollection $stock, array $combinations): int;
}
