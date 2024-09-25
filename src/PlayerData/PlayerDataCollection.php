<?php

namespace MyDramGames\Utils\PlayerData;

use MyDramGames\Utils\Php\Collection\Collection;
use MyDramGames\Utils\Player\Player;

interface PlayerDataCollection extends Collection
{
    /**
     * Shorthand method to get PlayerData object for specific Player from collection.
     * @param Player $player
     * @return PlayerData
     */
    public function getFor(Player $player): PlayerData;
}
