<?php

namespace Tests\Player;

use MyDramGames\Utils\Player\PlayerRegistered;
use MyDramGames\Utils\Player\PlayerRegisteredGeneric;
use PHPUnit\Framework\TestCase;

final class PlayerRegisteredGenericTest extends TestCase
{
    private array $playerOneAttribues = [
        'id' => 'test-id-1',
        'name' => 'Test1',
        'premium' => true,
    ];
    private array $playerTwoAttribues = [
        'id' => 'test-id-2',
        'name' => 'Test2',
        'premium' => false,
    ];

    private PlayerRegistered $playerOne;
    private PlayerRegistered $playerTwo;

    public function setUp(): void
    {
        $this->playerOne = new PlayerRegisteredGeneric(
            $this->playerOneAttribues['id'],
            $this->playerOneAttribues['name'],
            $this->playerOneAttribues['premium'],
        );
        $this->playerTwo = new PlayerRegisteredGeneric(
            $this->playerTwoAttribues['id'],
            $this->playerTwoAttribues['name'],
            $this->playerTwoAttribues['premium'],
        );
    }

    public function testGetId(): void
    {
        $this->assertSame($this->playerOneAttribues['id'], $this->playerOne->getId());
        $this->assertSame($this->playerTwoAttribues['id'], $this->playerTwo->getId());
    }

    public function testGetName(): void
    {
        $this->assertSame($this->playerOneAttribues['name'], $this->playerOne->getName());
        $this->assertSame($this->playerTwoAttribues['name'], $this->playerTwo->getName());
    }

    public function testIsRegistered(): void
    {
        $this->assertTrue($this->playerOne->isRegistered());
        $this->assertTrue($this->playerTwo->isRegistered());
    }

    public function testIsPremium(): void
    {
        $this->assertSame($this->playerOneAttribues['premium'], $this->playerOne->isPremium());
        $this->assertSame($this->playerTwoAttribues['premium'], $this->playerTwo->isPremium());
    }
}
