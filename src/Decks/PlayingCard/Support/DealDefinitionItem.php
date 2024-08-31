<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardCollection;

/**
 * Provide information how many cards should be dealt for specific stock
 */
interface DealDefinitionItem
{
    /**
     * @return PlayingCardCollection
     */
    public function getStock(): PlayingCardCollection;

    /**
     * Setting number of cards to null should result in distributing all remaining cards to such stocks one by one.
     * Returned int should be zero or more. Negative number of cards should not be accepted and returned.
     * @return int|null
     */
    public function getNumberOfCards(): ?int;

    /**
     * Informs how many cards still has to be dealt to stick meet deal definition criteria
     * @return int|null
     */
    public function getNumberOfPendingCards(): ?int;

    /**
     * Pass card from deck to this item stock. Should affect next use of method getNumberOfPendingCards
     * @param PlayingCard $playingCard
     * @return void
     */
    public function takeCardAndUpdatePendingCounter(PlayingCard $playingCard): void;
}