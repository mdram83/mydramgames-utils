<?php

namespace MyDramGames\Utils\Exceptions;

class DealDefinitionItemException extends MyDramGamesUtilsException
{
    public const string MESSAGE_NEGATIVE_NO_OF_CARDS = 'Negative number of cards not allowed';
    public const string MESSAGE_NOT_EXPECTED_CARD = 'Not expecting more cards for this deal';
}