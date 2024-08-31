<?php

namespace MyDramGames\Utils\Decks\PlayingCard\Support;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class DealDefinitionCollectionPowered extends CollectionPoweredExtendable implements DealDefinitionCollection
{
    protected const ?string TYPE_CLASS = DealDefinitionItem::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    /**
     * @inheritDoc
     */
    protected function getItemKey(mixed $item): mixed
    {
        return spl_object_hash($item);
    }

    public function getSumNumberOfCards(): int
    {
        return array_sum(array_map(fn($item) => $item->getNumberOfCards(), $this->toArray()));
    }
}