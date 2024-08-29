<?php

namespace Tests\Player;

use MyDramGames\Utils\Player\PlayerAnonymousGeneric;
use PHPUnit\Framework\TestCase;

final class PlayerAnonymousGenericTest extends TestCase
{
    private string $id = 'test-id-1';
    private string $name = 'Test1';
    private PlayerAnonymousGeneric $player;

    public function setUp(): void
    {
        parent::setUp();
        $this->player = new PlayerAnonymousGeneric($this->id, $this->name);
    }

    public function testGetId(): void
    {
        $this->assertSame($this->id, $this->player->getId());
    }

    public function testGetName(): void
    {
        $this->assertSame($this->name, $this->player->getName());
    }

    public function testIsRegistered(): void
    {
        $this->assertFalse($this->player->isRegistered());
    }

    public function testIsPremium(): void
    {
        $this->assertFalse($this->player->isPremium());
    }
}
