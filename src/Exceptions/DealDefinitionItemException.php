<?php

namespace MyDramGames\Utils\Exceptions;

class DealDefinitionItemException extends MyDramGamesUtilsException
{
    public const string MESSAGE_NEGATIVE_NO_OF_CARDS = 'Negative number of cards not allowed';
}