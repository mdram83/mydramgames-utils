<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

// TODO consider removing strict/unique params from all below methods. Not needed now. At the end where needed GameStewards should take this role
interface PlayingCardDealer
{
    // TODO consider if I really need this... It's probably just PlayingCardCollectionUnique constructor now...
    public function getEmptyStock(bool $unique = true): PlayingCardCollection;

    // TODO consider $definitions being dedicated class
    // TODO consider separating into 2 methods as some games may not require/allow shuffling...
    /**
     * Shuffle cards and distribute according to provided definitions
     * @param PlayingCardCollection $stock
     * @param array $definitions
     * @return void
     */
    public function shuffleAndDealCards(PlayingCardCollection $stock, array $definitions): void;

    // TODO consider moving to PlayingCardCollection
    public function getCardsByKeys(
        PlayingCardCollection $deck,
        ?array $keys,
        bool $unique = false,
        bool $strict = false
    ): PlayingCardCollection;

    // TODO consider moving to PlayerCardCollection
    public function getCardsKeys(PlayingCardCollection $stock): array;

    // TODO consider moving to PlayerCardCollection or even to Collection (new method sort(callable))
    public function getSortedCards(
        PlayingCardCollection $stock,
        array $keys,
        bool $strict = false
    ): PlayingCardCollection;

    // TODO consider using existing pullFirst method from Collection interface
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
     * Move cards between stocks provided number of times
     * @param PlayingCardCollection $fromStock
     * @param PlayingCardCollection $toStock
     * @param int $numberOfCards
     * @param bool $strict
     * @return void
     */
    public function moveCardsTimes(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        int $numberOfCards,
        bool $strict = false
    ): void;

    // TODO can I use spread operator ... for $fromStocks to force PlayingCardCollection types?
    /**
     * Collect all cards from array of stocks (expecting PlayingCardCollection)
     * @param PlayingCardCollection $toStock
     * @param array $fromStocks
     * @return PlayingCardCollection
     */
    public function collectCards(PlayingCardCollection $toStock, array $fromStocks): PlayingCardCollection;

    // TODO consider moving to PlayingCardCollection, maybe merge with below (count answer already if there is anything)
    public function hasStockAnyCombination(PlayingCardCollection $stock, array $combinations): bool;

    // TODO consider moving to PlayingCardCollection, maybe merge with below (count answer already if there is anything)
    public function countStockMatchingCombinations(PlayingCardCollection $stock, array $combinations): int;
}
