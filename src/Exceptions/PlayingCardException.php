<?php

namespace MyDramGames\Utils\Exceptions;

class PlayingCardException extends MyDramGamesUtilsException
{
    public const string MESSAGE_INCORRECT_PARAMS = 'Incorrect card parameters';
    public const string MESSAGE_MISSING_RANK = 'Rank is missing';
    public const string MESSAGE_MISSING_COLOR = 'Color is missing';
    public const string MESSAGE_MISSING_SUIT = 'Suit is missing';
}