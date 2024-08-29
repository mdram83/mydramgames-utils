<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

trait CollectionEngineTrait
{
    /**
     * Actual insertion of item to collection that happens after required validations
     * @param mixed $item
     * @param mixed|null $key
     * @return void
     */
    abstract protected function insert(mixed $item, mixed $key = null): void;

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
}