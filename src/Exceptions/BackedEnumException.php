<?php

namespace MyDramGames\Utils\Exceptions;

use MyDramGames\Utils\Exceptions\MyDramGamesUtilsException;

class BackedEnumException extends MyDramGamesUtilsException
{
    public const string MESSAGE_MISSING_VALUE = 'Value does not exist';
}
