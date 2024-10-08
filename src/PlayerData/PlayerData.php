<?php

namespace MyDramGames\Utils\PlayerData;

use MyDramGames\Utils\Player\Player;

/**
 * Purpose of this class is to store game related info for each player separately.
 * This in turn is going to help maintain cleaner logic of game play implementations.
 * Within specific extensions/implementations of this class you can store data like cards at hand, collected items etc.
 */
interface PlayerData
{
    /**
     * Return unique id (can be Player id) to help distinguish different instances, e.g. in collection.
     * @return int|string
     */
    public function getId(): int|string;

    /**
     * Return Player to which PlayerData instance is related to.
     * @return Player
     */
    public function getPlayer(): Player;

    /**
     * Supports easy extraction of player information as required per specific game.
     * @return array
     */
    public function toArray(): array;
}
