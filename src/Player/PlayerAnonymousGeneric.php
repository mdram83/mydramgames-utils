<?php

namespace MyDramGames\Utils\Player;

final readonly class PlayerAnonymousGeneric implements PlayerAnonymous
{
    public function __construct(
        private string $id,
        private string $name,
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

    /**
     * @inheritDoc
     */
    public function isRegistered(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isPremium(): bool
    {
        return false;
    }
}