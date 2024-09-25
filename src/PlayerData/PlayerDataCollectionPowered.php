<?php

namespace MyDramGames\Utils\PlayerData;

use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;
use MyDramGames\Utils\Player\Player;

class PlayerDataCollectionPowered extends CollectionPoweredExtendable implements PlayerDataCollection
{
    protected const ?string TYPE_CLASS = PlayerData::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getId();
    }

    /**
     * @throws CollectionException
     */
    public function getFor(Player $player): PlayerData
    {
        return $this->getOne($player->getId());
    }
}
