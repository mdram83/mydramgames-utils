<?php

namespace Tests;

use MyDramGames\Utils\Player\PlayerRegistered;
use MyDramGames\Utils\Player\PlayerRegisteredGeneric;

class TestingHelper
{
    private static array $playerRegisteredAttributes = [
        [
            'id' => '1111111-1111-11111111',
            'name' => 'Test 1',
            'premium' => false,
        ],
        [
            'id' => '22222222-2222-22222222',
            'name' => 'Test 2',
            'premium' => true,
        ]
    ];

    public static function getPlayerRegistered(bool $premium = false): PlayerRegistered
    {
        $playerKey = $premium ? 0 : 1;
        return (new PlayerRegisteredGeneric(
            self::$playerRegisteredAttributes[$playerKey]['id'],
            self::$playerRegisteredAttributes[$playerKey]['name'],
            self::$playerRegisteredAttributes[$playerKey]['premium'],
        ));
    }
}