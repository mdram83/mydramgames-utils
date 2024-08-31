<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardStocksCollection;

interface PlayingCardDealer
{
    /**
     * Shuffle cards and distribute according to provided definitions.
     * Allows to decide if deck should be shuffled and if requested cards should be dealt by one card or by definition
     * Remaining cards (DealDefinitionItem with null numberOfCards) are dealt on by one
     * @param PlayingCardCollection $deck
     * @param DealDefinitionCollection $definitions
     * @param bool $shuffleDeck
     * @param bool $dealOneCardPerDefinition when false, first definition get requested cards, then next.
     * @return void
     * @see DealDefinitionItem for details.
     */
    public function dealCards(
        PlayingCardCollection $deck,
        DealDefinitionCollection $definitions,
        bool $shuffleDeck = true,
        bool $dealOneCardPerDefinition = true,
    ): void;

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
     * Move cards between stocks provided number of times.
     * @param PlayingCardCollection $fromStock
     * @param PlayingCardCollection $toStock
     * @param int $numberOfCards
     * @return void
     */
    public function moveCardsTimes(
        PlayingCardCollection $fromStock,
        PlayingCardCollection $toStock,
        int $numberOfCards,
    ): void;

    /**
     * Collect all cards from collection of stocks to target stock and return target stock
     * @param PlayingCardCollection $toStock
     * @param PlayingCardStocksCollection $fromStocks
     * @return PlayingCardCollection
     */
    public function collectCards(PlayingCardCollection $toStock, PlayingCardStocksCollection $fromStocks): PlayingCardCollection;
}
