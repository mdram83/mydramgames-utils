<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

trait CollectionEngineTrait
{
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

    // TODO common between engine and extendable but extendable will just use engine call (no common thread required)
    final public function shuffle(): static
    {
        $keys = array_keys($this->toArray());
        shuffle($keys);

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->items[$key];
        }
        return $this->reset($items);
    }

    final public function add(mixed $item, mixed $key = null): static
    {
        // TODO duplicates validation could be then removed from Extendable...
        $this->validateNotDuplicate($key);
        $this->insert($item, $key);

        return $this;
    }

    // TODO common between engine and extendable, but will Extendable require this at all then when calling engine?
    /**
     * @throws CollectionException
     */
    final protected function validateNotEmpty(): void
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
    }

    // TODO common between engine and extendable, but will Extendable require this at all then when calling engine?
    /**
     * @throws CollectionException
     */
    final protected function validateNotDuplicate(mixed $key = null): void
    {
        if ($this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_DUPLICATE);
        }
    }

    // TODO common between engine and extendable, but will Extendable require this at all then when calling engine?
    /**
     * @throws CollectionException
     */
    final protected function validateExists(mixed $key): void
    {
        if (!$this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
        }
    }
}