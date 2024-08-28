<?php

namespace MyDramGames\Utils\Player;

use MyDramGames\Utils\Php\Collection\CollectionGeneric;

class PlayerCollectionGeneric extends CollectionGeneric implements PlayerCollection
{
    protected const ?string TYPE_CLASS =  Player::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getId();
    }
}
