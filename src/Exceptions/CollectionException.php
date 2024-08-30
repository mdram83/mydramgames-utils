<?php

namespace MyDramGames\Utils\Exceptions;

class CollectionException extends MyDramGamesUtilsException
{
    public const string MESSAGE_MISSING_KEY = 'Key missing in collection';
    public const string MESSAGE_NO_ELEMENTS = 'Collection is empty';
    public const string MESSAGE_INCOMPATIBLE = 'Collection element incompatible';
    public const string MESSAGE_DUPLICATE = 'Duplicate not expected in this collection';
    public const string MESSAGE_KEY_MODE_ERROR = 'Incompatible item key';
    public const string MESSAGE_KEYS_INPUTS = 'Incompatible requested keys list';
}