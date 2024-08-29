<?php

namespace Tests\GameCharacter;

use MyDramGames\Utils\GameCharacter\GameCharacterGeneric;
use MyDramGames\Utils\Player\Player;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameCharacterGenericTest extends TestCase
{
    private Player $player;
    private GameCharacterGeneric $character;
    private string $characterName = 'Test Character 1';

    public function setUp(): void
    {
        $this->player = TestingHelper::getPlayerRegistered();
        $this->character = new GameCharacterGeneric($this->characterName, $this->player);
    }

    public function testGetName(): void
    {
        $this->assertEquals($this->characterName, $this->character->getName());
    }

    public function testGetPlayer(): void
    {
        $this->assertEquals($this->player->getId(), $this->character->getPlayer()->getId());
    }
}
