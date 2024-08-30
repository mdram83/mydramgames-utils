<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class PlayingCardStockCollectionPowered extends CollectionPoweredExtendable implements PlayingCardStocksCollection
{
    protected const ?string TYPE_CLASS = PlayingCardCollection::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return spl_object_hash($item);
    }
}