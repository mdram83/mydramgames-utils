<?php

namespace MyDramGames\Utils\Player;

interface PlayerAnonymous extends Player
{
    /**
     * @return false
     */
    public function isRegistered(): bool;

    /**
     * @return false
     */
    public function isPremium(): bool;
}
