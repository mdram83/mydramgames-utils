<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

class CollectionEnginePhpArray implements CollectionEngine
{
    use CollectionEngineTrait;

    protected array $items;

    /**
     * @throws CollectionException
     */
    final public function __construct(array $items = [])
    {
        $this->reset($items);
    }

    /**
     * @inheritDoc
     */
    final public function count(): int
    {
        return count($this->items);
    }

    /**
     * @inheritDoc
     */
    final public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @inheritDoc
     */
    final public function exist(mixed $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @inheritDoc
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * @inheritDoc
     */
    final public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    final public function each(callable $callback): static
    {
        $this->items = array_map($callback, $this->items);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function filter(callable $callback): static
    {
        return new static(array_filter($this->items, $callback));
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    final public function random(): mixed
    {
        $this->validateNotEmpty();
        return $this->items[array_rand($this->items)];
    }

    /**
     * @inheritDoc
     */
    final public function reset(array $items = []): static
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getOne(mixed $key): mixed
    {
        $this->validateExists($key);
        return $this->items[$key];
    }

    /**
     * @inheritDoc
     */
    public function getMany(array $keys): static
    {
        $this->validateKeysInputArray($keys);
        $this->validateExistMany($keys);

        return new static(array_filter($this->items, fn($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY));
    }

    /**
     * @inheritDoc
     */
    final public function removeOne(mixed $key): void
    {
        $this->validateExists($key);
        unset($this->items[$key]);
    }

    /**
     * @inheritDoc
     */
    final public function removeAll(): void
    {
        $this->items = [];
    }

    /**
     * @inheritDoc
     */
    final public function pullFirst(): mixed
    {
        $this->validateNotEmpty();

        $reversedItems = array_reverse($this->items);
        $firstItem = array_pop($reversedItems);
        $this->items = array_reverse($reversedItems);

        return $firstItem;
    }

    /**
     * @inheritDoc
     */
    final public function pullLast(): mixed
    {
        $this->validateNotEmpty();
        return array_pop($this->items);
    }

    /**
     * @inheritDoc
     */
    final public function clone(): static
    {
        return clone $this;
    }

    final protected function insert(mixed $item, mixed $key = null): void
    {
        isset($key) ? $this->items[$key] = $item : $this->items[] = $item;
    }
}
