<?php

namespace MyDramGames\Utils\Player;

interface PlayerRegistered extends Player
{
    /**
     * @return true
     */
    public function isRegistered(): bool;
}
