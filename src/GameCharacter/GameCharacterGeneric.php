<?php

namespace MyDramGames\Utils\GameCharacter;

use MyDramGames\Utils\GameCharacter\GameCharacter;
use MyDramGames\Utils\Player\Player;

class GameCharacterGeneric implements GameCharacter
{
    public function __construct(
        protected string $name,
        protected Player $player,
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
