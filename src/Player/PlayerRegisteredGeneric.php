<?php

namespace MyDramGames\Utils\Player;

final readonly class PlayerRegisteredGeneric implements PlayerRegistered
{
    public function __construct(
        private string $id,
        private string $name,
        private bool $premium,
    )
    {

    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPremium(): bool
    {
        return $this->premium;
    }

    /**
     * @inheritDoc
     */
    public function isRegistered(): bool
    {
        return true;
    }
}