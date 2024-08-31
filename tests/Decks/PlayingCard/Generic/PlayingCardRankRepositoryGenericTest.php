<?php

namespace Tests\Decks\PlayingCard\Generic;

use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardRankGeneric;
use MyDramGames\Utils\Decks\PlayingCard\Generic\PlayingCardRankRepositoryGeneric;
use MyDramGames\Utils\Decks\PlayingCard\PlayingCardRankRepository;
use MyDramGames\Utils\Exceptions\PlayingCardException;
use PHPUnit\Framework\TestCase;

class PlayingCardRankRepositoryGenericTest extends TestCase
{
    private PlayingCardRankRepositoryGeneric $repository;

    public function setUp(): void
    {
        $this->repository = new PlayingCardRankRepositoryGeneric();
    }

    public function testInterfaceInstance(): void
    {
        $this->assertInstanceOf(PlayingCardRankRepository::class, $this->repository);
    }

    public function testThrowExceptionWhenGettingMissingKey(): void
    {
        $this->expectException(PlayingCardException::class);
        $this->expectExceptionMessage(PlayingCardException::MESSAGE_MISSING_RANK);

        $this->repository->getOne('definitely-123-missing456-rank-key');
    }

    public function testGetOne(): void
    {
         $rank = PlayingCardRankGeneric::cases()[0];
         $this->assertEquals($rank, $this->repository->getOne($rank->getKey()));
    }
}
