<?php

namespace MyDramGames\Utils\Player;

interface Player
{
    public function getId(): int|string;
    public function getName(): string;
    public function isRegistered(): bool;
    public function isPremium(): bool;
}
