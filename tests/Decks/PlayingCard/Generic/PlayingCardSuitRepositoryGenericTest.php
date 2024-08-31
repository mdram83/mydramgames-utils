<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardSuitGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardSuitRepositoryGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardSuitRepository;
use MyDramGames\Utils\Exceptions\PlayingCardException;
use PHPUnit\Framework\TestCase;

class PlayingCardSuitRepositoryGenericTest extends TestCase
{
    private PlayingCardSuitRepositoryGeneric $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new PlayingCardSuitRepositoryGeneric();
    }

    public function testInterfaceInstance(): void
    {
        $this->assertInstanceOf(PlayingCardSuitRepository::class, $this->repository);
    }

    public function testThrowExceptionWhenGettingMissingKey(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_MISSING_SUIT);

        $this->repository->getOne('definitely-123-missing456-suit-key');
    }

    public function testGetOne(): void
    {
         $suit = PlayingCardSuitGeneric::cases()[0];
         $this->assertEquals($suit, $this->repository->getOne($suit->getKey()));
    }
}
