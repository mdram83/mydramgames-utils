<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\PlayingCard;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardFactory;
use MyDramGames\Utils\Exceptions\PlayingCardException;

class PlayingCardFactoryGeneric implements PlayingCardFactory
{
    /**
     * @throws PlayingCardException
     */
    public function create(string $key): PlayingCard
    {
        [$rank, $suit, $color] = $this->getValidatedParams($key);

        return new PlayingCardGeneric($rank, $suit ?? null, $color ?? null);
    }

    /**
     * @throws PlayingCardException
     */
    private function getValidatedParams(string $key): array
    {
        [$rankKey, $suitOrColorKey] = explode(PlayingCardGeneric::PLAYING_CARD_KEY_SEPARATOR, $key, 2);

        if (!$rank = PlayingCardRankGeneric::tryFrom($rankKey)) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_MISSING_RANK);
        }

        if ($rank->isJoker() && !$color = array_filter(PlayingCardColorGeneric::cases(), fn($color) => $color->getName() === $suitOrColorKey)[0] ?? null) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_MISSING_COLOR);
        }

        if (!$rank->isJoker() && !$suit = PlayingCardSuitGeneric::tryFrom($suitOrColorKey)) {
            throw new PlayingCardException(PlayingCardException::MESSAGE_MISSING_SUIT);
        }

        return [$rank, $suit ?? null, $color ?? null];
    }
}
