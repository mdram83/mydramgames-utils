<?php

namespace MyDramGames\Utils\Exceptions;

class PlayingCardDealerException extends MyDramGamesUtilsException
{
    public const string MESSAGE_DISTRIBUTION_DEFINITION = 'Incorrect distribution definition';
    public const string MESSAGE_NOT_ENOUGH_IN_STOCK = 'Not enough cards in requested stock';
    public const string MESSAGE_KEY_MISSING_IN_STOCK = 'Requested keys missing in stock';
}