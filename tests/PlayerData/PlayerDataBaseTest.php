<?php

namespace Tests\PlayerData;

use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\PlayerData\PlayerDataBase;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class PlayerDataBaseTest extends TestCase
{
    protected PlayerDataBase $data;
    protected Player $player;

    public function setUp(): void
    {
        $this->player = $this->createMock(Player::class);
        $this->player->method('getId')->willReturn(1);
        $this->player->method('getName')->willReturn('Player 1');

        $this->data = $this->getPlayerData($this->player);
    }

    public function getPlayerData(Player $player): PlayerDataBase
    {
        return TestingHelper::getPlayerDataBase($player);
    }

    public function testGetId(): void
    {
        $this->assertSame($this->player->getId(), $this->data->getId());
    }

    public function testSeat(): void
    {
        $this->data->seat = 1;
        $this->assertEquals(
            [
                'id' => $this->player->getId(),
                'name' => $this->player->getName(),
                'seat' => 1,
            ],
            $this->data->toArray()
        );
    }
}
