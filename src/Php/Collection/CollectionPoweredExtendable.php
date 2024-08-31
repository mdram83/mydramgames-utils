<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

/**
 * To support specific collection types, define TYPE_CLASS or TYPE_PRIMITIVE values in child class.
 * To support specific key mode, define KEY_MODE value (loose, forced, method) in child class.
 */
class CollectionPoweredExtendable implements Collection
{
    protected CollectionEngine $engine;

    protected const ?string TYPE_CLASS = null;
    protected const ?string TYPE_PRIMITIVE = null;

    final protected const int KEYS_LOOSE = 0;
    final protected const int KEYS_FORCED = 1;
    final protected const int KEYS_METHOD = 2;

    /**
     * KEYS_LOOSE = 0 results in using array keys during reset() and provided or auto-generated key during add().
     * KEYS_FORCED = 1 results in using array keys during reset() and provided key during add() else throws exception.
     * KEYS_METHOD = 2 results in using getItemKey() during reset() and add(), throws exception if other provided.
     */
    protected const int KEY_MODE = self::KEYS_LOOSE;

    /**
     * Generate item key based on item. Adjust this method in child class when setting KEY_MODE to KEYS_CALLABLE.
     * @param mixed $item
     * @return mixed
     */
    protected function getItemKey(mixed $item): mixed
    {
        return null;
    }

    /**
     * @throws CollectionException
     */
    final public function __construct(CollectionEngine $engine = null, array $items = [])
    {
        $this->engine = $engine?->reset() ?? new CollectionEnginePhpArray();
        $this->reset($items);
    }

    final public function count(): int
    {
        return $this->engine->count();
    }

    final public function isEmpty(): bool
    {
        return $this->engine->isEmpty();
    }

    final public function exist(mixed $key): bool
    {
        return $this->engine->exist($key);
    }

    final public function keys(): array
    {
        return $this->engine->keys();
    }

    final public function toArray(): array
    {
        return $this->engine->toArray();
    }

    final public function each(callable $callback): static
    {
        return $this->reset($this->engine->each($callback)->toArray());
    }

    final public function filter(callable $callback): static
    {
        return new static($this->engine->clone()->reset(), $this->engine->filter($callback)->toArray());
    }

    final public function shuffle(): static
    {
        $this->engine->shuffle();
        return $this;
    }

    final public function sortKeys(callable $callback): static
    {
        $this->engine->sortKeys($callback);
        return $this;
    }

    final public function random(): mixed
    {
        return $this->engine->random();
    }

    final public function reset(array $items = []): static
    {
        $this->removeAll();
        foreach ($items as $key => $item) {
            $this->add($item, $this::KEY_MODE === $this::KEYS_METHOD ? null : $key);
        }
        return $this;
    }

    final public function add(mixed $item, mixed $key = null): static
    {
        $this->validateItemType($item);
        $this->validateKeyMode($key);

        $key = $this::KEY_MODE === $this::KEYS_METHOD ? $this->getItemKey($item) : $key;

        $this->engine->add($item, $key);

        return $this;
    }

    final public function getOne(mixed $key): mixed
    {
        return $this->engine->getOne($key);
    }

    final public function getMany(array $keys): static
    {
        $items = $this->engine->getMany($keys)->toArray();
        return $this->clone()->reset($items);
    }

    final public function pull(mixed $key): mixed
    {
        return $this->engine->pull($key);
    }

    final public function removeOne(mixed $key): void
    {
        $this->engine->removeOne($key);
    }

    final public function removeAll(): void
    {
        $this->engine->removeAll();
    }

    final public function pullFirst(): mixed
    {
        return $this->engine->pullFirst();
    }

    final public function pullLast(): mixed
    {
        return $this->engine->pullLast();
    }

    /**
     * @throws CollectionException
     */
    final public function clone(): static
    {
        return new static($this->engine->clone()->reset(), $this->engine->toArray());
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
        if ($this::KEY_MODE === $this::KEYS_FORCED && $key === null) {
            throw new CollectionException(CollectionException::MESSAGE_KEY_MODE_ERROR);
        }

        if ($this::KEY_MODE === $this::KEYS_METHOD && $key !== null) {
            throw new CollectionException(CollectionException::MESSAGE_KEY_MODE_ERROR);
        }
    }
}
