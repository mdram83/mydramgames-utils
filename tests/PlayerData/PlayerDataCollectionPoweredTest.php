<?php

namespace Tests\PlayerData;

use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\PlayerData\PlayerData;
use MyDramGames\Utils\PlayerData\PlayerDataBase;
use MyDramGames\Utils\PlayerData\PlayerDataCollection;
use MyDramGames\Utils\PlayerData\PlayerDataCollectionPowered;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class PlayerDataCollectionPoweredTest extends TestCase
{
    protected PlayerDataBase $playerDataOne;
    protected PlayerDataBase $playerDataTwo;

    public function setUp(): void
    {
        $playerOne = $this->createMock(Player::class);
        $playerOne->method('getId')->willReturn(1);
        $playerOne->method('getName')->willReturn('Player 1');

        $playerTwo = $this->createMock(Player::class);
        $playerTwo->method('getId')->willReturn(2);
        $playerTwo->method('getName')->willReturn('Player 2');

        $this->playerDataOne = TestingHelper::getPlayerDataBase($playerOne);
        $this->playerDataTwo = TestingHelper::getPlayerDataBase($playerTwo);
    }

    public function testConstructNoParams(): void
    {
        $this->assertInstanceOf(PlayerDataCollection::class, new PlayerDataCollectionPowered());
    }

    public function testConstructValues(): void
    {
        $this->assertInstanceOf(PlayerDataCollection::class, new PlayerDataCollectionPowered(
            TestingHelper::getCollectionEngine(),
            [$this->playerDataOne, $this->playerDataTwo]
        ));
    }

    public function testConstructThrowExpcetionDuplicate(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        new PlayerDataCollectionPowered(null, [$this->playerDataOne, $this->playerDataOne]);
    }

    public function testAddThrowExceptionDuplicate(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $collection = new PlayerDataCollectionPowered(null, [$this->playerDataOne]);
        $collection->add($this->playerDataOne);
    }

    public function testAddThrowExceptionIncompatibleClass(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_INCOMPATIBLE);

        $collection = new PlayerDataCollectionPowered(null, [$this->playerDataOne]);
        $collection->add($this->createMock(Player::class));
    }

    public function testAdd(): void
    {
        $collection = new PlayerDataCollectionPowered(null, [$this->playerDataOne]);
        $collection->add($this->playerDataTwo);

        $this->assertEquals(2, $collection->count());
    }
}
