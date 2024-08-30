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

    /**
     * @throws CollectionException
     */
    final protected function validateExistMany(array $keys): void
    {
        if (array_diff($keys, $this->keys())) {
            throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
        }
    }

    /**
     * @throws CollectionException
     */
    final protected function validateKeysInputArray(array $keys): void
    {
        foreach ($keys as $key) {
            if (!is_int($key) && !is_string($key)) {
                throw new CollectionException(CollectionException::MESSAGE_KEYS_INPUTS);
            }
        }
    }
}