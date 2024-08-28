<?php

namespace Tests\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

trait CollectionTrait
{
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
     * @throws CollectionException
     */
    final public function __construct(array $items = [])
    {
        $this->reset($items);
    }

    /**
     * Actual insertion of item to collection that happens after required validations
     * @param mixed $item
     * @param mixed|null $key
     * @return void
     */
    abstract protected function insert(mixed $item, mixed $key = null): void;

    /**
     * Generate item key based on item. Adjust this method in child class when setting KEY_MODE to KEYS_CALLABLE.
     * @param mixed $item
     * @return mixed
     */
    abstract protected function getItemKey(mixed $item): mixed;

    final public function shuffle(): static
    {
        $collectionItems = $this->toArray();

        $keys = array_keys($collectionItems);
        shuffle($keys);

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->items[$key];
        }
        return $this->reset($items);
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

        $this->validateNotDuplicate($key);
        $this->insert($item, $key);

        return $this;
    }

    /**
     * @throws CollectionException
     */
    final protected function validateNotEmpty(): void
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
    }

    /**
     * @throws CollectionException
     */
    final protected function validateNotDuplicate(mixed $key = null): void
    {
        if ($this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_DUPLICATE);
        }
    }

    /**
     * @throws CollectionException
     */
    final protected function validateExists(mixed $key): void
    {
        if (!$this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
        }
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
