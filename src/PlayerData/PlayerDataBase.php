<?php

namespace MyDramGames\Utils\PlayerData;

use MyDramGames\Utils\Player\Player;

/**
 * This abstract class target to fulfill minimum but most common use case.
 * You can extend it as required in your implementations.
 * Consider using public properties (as in this example) or any other setter/getter convention.
 */
abstract class PlayerDataBase implements PlayerData
{
    /**
     * Example of most common parameter implementation using publicly accessible variable.
     * @var int
     */
    public int $seat;

    public function __construct(readonly protected Player $player)
    {

    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string
    {
        return $this->player->getId();
    }

    /**
     * @inheritDoc
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @inheritDoc
     */
    abstract public function toArray(): array;
}
