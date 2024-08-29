<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class PlayingCardCollectionPoweredUnique extends CollectionPoweredExtendable implements PlayingCardCollection
{
    protected const ?string TYPE_CLASS = PlayingCard::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getKey();
    }
}