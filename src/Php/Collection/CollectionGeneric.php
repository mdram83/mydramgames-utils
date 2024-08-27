<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

// TODO add tests for types and keys to methods reset, add, each, shuffle, INCLUDING toArray check

/**
 * To support specific items types, define TYPE_CLASS or TYPE_PRIMITIVE values in child class.
 * To support specific key mode, define KEY_MODE value (loose, forced, method) in child class.
 */
class CollectionGeneric implements Collection
{
    protected array $items;

    protected const ?string TYPE_CLASS = null;
    protected const ?string TYPE_PRIMITIVE = null;

    final protected const int KEYS_LOOSE = 0;
    final protected const int KEYS_FORCED = 1;
    final protected const int KEYS_METHOD = 2;

    /**
     * KEYS_LOOSE = 0 results in using array keys during reset() and provided or generated key during add().
     * KEYS_FORCED = 1 results in using array keys during reset() and provided key during add() else throws exception.
     * KEYS_METHOD = 2 results in using callableItemKey() during reset() and add() else throws exception.
     */
    protected const int KEY_MODE = self::KEYS_LOOSE;

    /**
     * @throws CollectionException
     */
    final public function __construct(array $items = [])
    {
        $this->reset($items);
    }

    final public function count(): int
    {
        return count($this->items);
    }

    final public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    final public function exist(mixed $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    final public function toArray(): array
    {
        return $this->items;
    }

    final public function each(callable $callback): static
    {
        $items = array_map($callback, $this->items);
        return $this->reset($items);
    }

    final public function filter(callable $callback): static
    {
        return new static(array_filter($this->items, $callback));
    }

    final public function shuffle(): static
    {
        $keys = array_keys($this->items);
        shuffle($keys);

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->items[$key];
        }
        return $this->reset($items);
    }

    final public function random(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return $this->items[array_rand($this->items)];
    }

    final public function reset(array $items = []): static
    {
        $this->items = [];
        foreach ($items as $key => $item) {
            $this->add($item, self::KEY_MODE === self::KEYS_METHOD ? null : $key);
        }
        return $this;
    }

    final public function add(mixed $item, mixed $key = null): static
    {
        $this->validateItemType($item);
        $this->validateKeyMode($key);

        $key = self::KEY_MODE === self::KEYS_METHOD ? $this->getItemKey($item) : $key;

        if ($this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_DUPLICATE);
        }

        isset($key) ? $this->items[$key] = $item : $this->items[] = $item;

        return $this;
    }

    final public function getOne(mixed $key): mixed
    {
        if (!$this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
        }
        return $this->items[$key];
    }

    final public function removeOne(mixed $key): void
    {
        if (!$this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
        }
        unset($this->items[$key]);
    }

    final public function removeAll(): void
    {
        $this->items = [];
    }

    final public function pullFirst(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }

        $reversedItems = array_reverse($this->items);
        $firstItem = array_pop($reversedItems);
        $this->items = array_reverse($reversedItems);

        return $firstItem;
    }

    final public function pullLast(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return array_pop($this->items);
    }

    final public function clone(): static
    {
        return clone $this;
    }

    /**
     * @throws CollectionException
     */
    final protected function validateItemType(mixed $item): void
    {
        $typeClass = $this::TYPE_CLASS;
        if (isset($typeClass) && !($item instanceof $typeClass)) {
            throw new CollectionException(CollectionException::MESSAGE_INCOMPATIBLE);
        }

        $typePrimitive = $this::TYPE_PRIMITIVE;
        if (isset($typePrimitive) && !(gettype($item) === $typePrimitive)) {
            throw new CollectionException(CollectionException::MESSAGE_INCOMPATIBLE);
        }
    }

    /**
     * @throws CollectionException
     */
    final protected function validateKeyMode(mixed $key): void
    {
        if (self::KEY_MODE === self::KEYS_FORCED && $key === null) {
            throw new CollectionException(CollectionException::MESSAGE_KEY_MODE_ERROR);
        }

        if (self::KEY_MODE === self::KEYS_METHOD && $key !== null) {
            throw new CollectionException(CollectionException::MESSAGE_KEY_MODE_ERROR);
        }
    }

    /**
     * Generate item key based on item value or method. Overwrite this method when setting KEY_MODE to KEYS_CALLABLE
     * @param mixed $item
     * @return mixed
     */
    protected function getItemKey(mixed $item): mixed
    {
        return null;
    }
}
