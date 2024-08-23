<?php

namespace MyDramGames\Utils\Exceptions;

use Exception;

class GameBoardException extends Exception
{
    public const string MESSAGE_INVALID_FIELD_VALUE = 'Invalid field value';
    public const string MESSAGE_INVALID_FIELD_ID = 'Invalid field id';
    public const string MESSAGE_FIELD_ALREADY_SET = 'Field value already set';
}
