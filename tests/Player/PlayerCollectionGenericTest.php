<?php

namespace Tests\Player;

use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Php\Collection\Collection;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;
use MyDramGames\Utils\Player\PlayerCollectionGeneric;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class PlayerCollectionGenericTest extends TestCase
{
    private PlayerCollectionGeneric $collection;
    private Player $playerOne;
    private Player $playerTwo;
    private Player $playerThree;
    private array $initialPlayers;

    public function setUp(): void
    {
        $this->playerOne = TestingHelper::getPlayerRegistered();
        $this->playerTwo = TestingHelper::getPlayerAnonymous();
        $this->playerThree = TestingHelper::getPlayerRegistered(true);
        $this->initialPlayers = [$this->playerOne, $this->playerTwo];
        $this->collection = new PlayerCollectionGeneric($this->initialPlayers);
    }

    public function testInterface(): void
    {
        $this->assertInstanceOf(PlayerCollection::class, $this->collection);
        $this->assertInstanceOf(Collection::class, $this->collection);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->playerThree);
        $this->assertTrue($this->collection->exist($this->playerThree->getId()));
    }

    public function testAddThrowExceptionForDuplicatedId(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->playerOne);
    }
}
