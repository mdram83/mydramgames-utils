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
        try {
            $this->getOne($key);
            return true;
        } catch (CollectionException) {
            return false;
        }
    }

    final public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$item['key']] = $item['value'];
        }
        return $items;
    }

    final public function each(callable $callback): static
    {
        $items = [];
        foreach ($this->items as $index => $item) {
            $items[$item['key']] = $callback($item['value']);
        }
        return $this->reset($items);
    }

    final public function filter(callable $callback): static
    {
        $items = [];
        foreach ($this->items as $item) {
            if (array_filter([$item['key'] => $item['value']], $callback, ARRAY_FILTER_USE_BOTH)) {
                $items[$item['key']] = $item['value'];
            }
        }
        return new static($items);
    }

    final public function shuffle(): static
    {
        /* TODO re-work in case I decide to flatten $this->items. Example below.
        * $keys = array_keys($list);
        * shuffle($keys);
        * $random = array();
        * foreach ($keys as $key)
        * $random[$key] = $list[$key];
        * return $random;
        */
        shuffle($this->items);
        return $this;
    }

    final public function random(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return $this->items[array_rand($this->items)]['value'];
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

        // TODO remove random key in case I decide to flatten $this->items;
        $key = self::KEY_MODE === self::KEYS_METHOD
            ? $this->getItemKey($item)
            : $key ?? vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

        if ($this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_DUPLICATE);
        }

        $this->items[] = ['key' => $key, 'value' => $item];

        return $this;
    }

    final public function getOne(mixed $key): mixed
    {
        foreach ($this->items as $item) {
            if ($item['key'] === $key) {
                return $item['value'];
            }
        }

        throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
    }

    final public function removeOne(mixed $key): void
    {
        foreach ($this->items as $index => $item) {
            if ($item['key'] === $key) {
                unset($this->items[$index]);
                return;
            }
        }

        throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
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
        return array_shift($this->items)['value'];
    }

    final public function pullLast(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return array_pop($this->items)['value'];
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
