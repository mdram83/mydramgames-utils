<?php

namespace MyDramGames\Utils\GameBoard;

interface GameBoard
{
    public function toJson(): string;
    public function setFromJson(string $jsonBoard): void;
}
