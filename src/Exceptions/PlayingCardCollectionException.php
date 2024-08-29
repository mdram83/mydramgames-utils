<?php

namespace MyDramGames\Utils\Exceptions;

use MyDramGames\Utils\Exceptions\MyDramGamesUtilsException;

class PlayingCardCollectionException extends MyDramGamesUtilsException
{
    public const string MESSAGE_INCORRECT_COMBINATION = 'Incorrect keysCombination structure';
}