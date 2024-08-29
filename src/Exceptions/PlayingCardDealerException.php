<?php

namespace MyDramGames\Utils\Exceptions;

class PlayingCardDealerException extends MyDramGamesUtilsException
{
    public const string MESSAGE_DISTRIBUTION_DEFINITION = 'Incorrect distribution definition';
    public const string MESSAGE_COLLECTION_FROM_INVALID = 'Invalid stock to collect from';
    public const string MESSAGE_NOT_ENOUGH_TO_DEAL = 'Not enough cards in deck to deal according to definition';
    public const string MESSAGE_NOT_ENOUGH_IN_STOCK = 'Not enough cards in requested stock';
    public const string MESSAGE_NOT_UNIQUE_KEYS = 'Requested keys are not unique';
    public const string MESSAGE_KEY_MISSING_IN_STOCK = 'Requested keys missing in stock';
    public const string MESSAGE_KEYS_NOT_MATCHING_STOCK = 'Requested keys not matching stock';
    public const string MESSAGE_COMBINATION_INVALID = 'Combination format invalid';
}