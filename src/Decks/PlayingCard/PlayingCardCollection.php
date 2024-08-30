<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

use MyDramGames\Utils\Exceptions\PlayingCardCollectionException;
use MyDramGames\Utils\Php\Collection\Collection;

interface PlayingCardCollection extends Collection
{
    /**
     * Count occurrences of combination of cards within collection.
     * Structure of $keysCombinations should be e.g. [[key-1, key-2], [key-1, key-3]].
     * @param array $keysCombinations
     * @return int
     * @throws PlayingCardCollectionException
     */
    public function countMatchingKeysCombinations(array $keysCombinations): int;

    /**
     * Sort collection by specific order of keys provided in array. Modifies original collection.
     * Keys provided in parameter has priority over keys missing in parameter when sorting.
     * Structure of $keys should be [key-1, key-2 ...]
     * @param array $keys
     * @return $this
     * @throws PlayingCardCollectionException
     */
    public function sortByKeys(array $keys): static;
}