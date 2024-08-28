<?php

namespace MyDramGames\Utils\Php\Collection;

/**
 * To support specific collection types, define TYPE_CLASS or TYPE_PRIMITIVE values in child class.
 * To support specific key mode, define KEY_MODE value (loose, forced, method) in child class.
 * See details in CollectionTrait PHPDoc
 */
class CollectionGeneric implements Collection
{
    use CollectionTrait;

    protected array $items;

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

    final public function random(): mixed
    {
        $this->validateNotEmpty();
        return $this->items[array_rand($this->items)];
    }

    final public function getOne(mixed $key): mixed
    {
        $this->validateExists($key);
        return $this->items[$key];
    }

    final public function removeOne(mixed $key): void
    {
        $this->validateExists($key);
        unset($this->items[$key]);
    }

    final public function removeAll(): void
    {
        $this->items = [];
    }

    final public function pullFirst(): mixed
    {
        $this->validateNotEmpty();

        $reversedItems = array_reverse($this->items);
        $firstItem = array_pop($reversedItems);
        $this->items = array_reverse($reversedItems);

        return $firstItem;
    }

    final public function pullLast(): mixed
    {
        $this->validateNotEmpty();
        return array_pop($this->items);
    }

    final public function clone(): static
    {
        return clone $this;
    }

    protected function getItemKey(mixed $item): mixed
    {
        return null;
    }

    protected function insert(mixed $item, mixed $key = null): void
    {
        isset($key) ? $this->items[$key] = $item : $this->items[] = $item;
    }
}
