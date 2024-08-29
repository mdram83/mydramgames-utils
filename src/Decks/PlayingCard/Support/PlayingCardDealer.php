<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;

interface PlayingCardDealer
{
//    public function getEmptyStock(bool $unique = true): PlayingCardCollection; // TODO not needed, install in dedicated GameServicesProvider to use within specific GamePlay

    /**
     * Shuffle cards and distribute according to provided definitions
     * @param PlayingCardCollection $stock
     * @param DealDefinitionCollection $definition
     * @param bool $shuffleStock
     * @return void
     */
    public function dealCards(PlayingCardCollection $stock, DealDefinitionCollection $definition, bool $shuffleStock = true): void;

    // TODO move to Collection new method getMany(array $keys);
    public function getCardsByKeys(
        PlayingCardCollection $deck,
        array $keys,
    ): PlayingCardCollection;

    // TODO move to Collection new method keys();
    public function getCardsKeys(PlayingCardCollection $stock): array;

    // TODO move to Collection new method sort(callable);
    public function getSortedCards(
        PlayingCardCollection $stock,
        array $keys,
    ): PlayingCardCollection;

    // TODO use Collection method pullFirst();
    public function pullFirstCard(PlayingCardCollection $stock, bool $strict = false): ?PlayingCard;


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

//    public function hasStockAnyCombination(PlayingCardCollection $stock, array $combinations): bool; // TODO remove and use count... method instead

//    public function countStockMatchingCombinations(PlayingCardCollection $stock, array $combinations): int; // TODO moved to PlayingCardCollection
}
