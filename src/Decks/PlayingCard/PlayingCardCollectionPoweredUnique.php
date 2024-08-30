<?php

namespace MyDramGames\Utils\Decks\PlayingCard;

use MyDramGames\Utils\Exceptions\PlayingCardCollectionException;
use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class PlayingCardCollectionPoweredUnique extends CollectionPoweredExtendable implements PlayingCardCollection
{
    protected const ?string TYPE_CLASS = PlayingCard::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getKey();
    }

    public function countMatchingKeysCombinations(array $keysCombinations): int
    {
        $this->validateKeysCombinations($keysCombinations);

        return array_reduce($keysCombinations, function ($carry, $combination) {

            if ($combination === []) {
                return $carry;
            }

            foreach ($combination as $element) {
                if (!$this->exist($element)) {
                    return $carry;
                }
            }

            return $carry + 1;

        }, 0);
    }

    public function sortByKeys(array $keys): static
    {
        return $this->sortKeys(function($keyOne, $keyTwo) use ($keys): int {
            $keys = array_reverse($keys);

            $keyOnePriority = !in_array($keyOne, $keys) ? -1 : array_search($keyOne, $keys);
            $keyTwoPriority = !in_array($keyTwo, $keys) ? -1 : array_search($keyTwo, $keys);

            return $keyOnePriority < $keyTwoPriority;
        });
    }

    /**
     * @throws PlayingCardCollectionException
     */
    private function validateKeysCombinations(array $keysCombinations): void
    {
        foreach ($keysCombinations as $combination) {
            if (!is_array($combination)) {
                throw new PlayingCardCollectionException(PlayingCardCollectionException::MESSAGE_INCORRECT_COMBINATION);
            }
            foreach ($combination as $element) {
                if (!is_string($element) || $element === '') {
                    throw new PlayingCardCollectionException(PlayingCardCollectionException::MESSAGE_INCORRECT_COMBINATION);
                }
            }
        }
    }
}