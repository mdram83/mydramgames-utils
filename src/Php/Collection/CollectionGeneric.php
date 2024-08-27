<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

final class CollectionGeneric implements Collection
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->reset($items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function exist(mixed $key): bool
    {
        try {
            $this->getOne($key);
            return true;
        } catch (CollectionException) {
            return false;
        }
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$item['key']] = $item['value'];
        }
        return $items;
    }

    public function each(callable $callback): static
    {
        foreach ($this->items as $index => $item) {
            $this->items[$index]['value'] = $callback($item['value']);
        }
        return $this;
    }

    public function filter(callable $callback): static
    {
        $items = [];
        foreach ($this->items as $item) {
            if (array_filter([$item['key'] => $item['value']], $callback, ARRAY_FILTER_USE_BOTH)) {

                $items[$item['key']] = $item['value'];
            }
        }
        return new static($items);
    }

    public function shuffle(): static
    {
        shuffle($this->items);
        return $this;
    }

    public function random(): mixed
    {
        return $this->isEmpty() ? null : $this->items[array_rand($this->items)]['value'];
    }

    public function assignKeys(callable $callback): static
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$callback($item['value'])] = $item['value'];
        }
        return $this->reset($items);
    }

    public function reset(array $items = []): static
    {
        $this->items = [];
        foreach ($items as $key => $value) {
            $this->items[] = ['key' => $key, 'value' => $value];
        }
        return $this;
    }

    public function add(mixed $item, mixed $key = null): static
    {
        if (isset($key) && $this->exist($key)) {
            throw new CollectionException(CollectionException::MESSAGE_DUPLICATE);
        }

        $key = $key ?? vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $this->items[] = ['key' => $key, 'value' => $item];

        return $this;
    }

    public function getOne(mixed $key): mixed
    {
        foreach ($this->items as $item) {
            if ($item['key'] === $key) {
                return $item['value'];
            }
        }

        throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
    }

    public function removeOne(mixed $key): void
    {
        foreach ($this->items as $index => $item) {
            if ($item['key'] === $key) {
                unset($this->items[$index]);
                return;
            }
        }

        throw new CollectionException(CollectionException::MESSAGE_MISSING_KEY);
    }

    public function removeAll(): void
    {
        $this->reset();
    }

    public function pullFirst(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return array_shift($this->items)['value'];
    }

    public function pullLast(): mixed
    {
        if ($this->isEmpty()) {
            throw new CollectionException(CollectionException::MESSAGE_NO_ELEMENTS);
        }
        return array_pop($this->items)['value'];
    }

    public function clone(): static
    {
        return clone $this;
    }
}