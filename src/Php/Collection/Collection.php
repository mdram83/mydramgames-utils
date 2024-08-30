<?php

namespace MyDramGames\Utils\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;

interface Collection
{
    /**
     * Count collection elements
     * @return int
     */
    public function count(): int;

    /**
     * Informs if collection has no elements
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Informs if collection has element with specific key
     * @param mixed $key
     * @return bool
     */
    public function exist(mixed $key): bool;

    /**
     * Return array of collection keys
     * @return array
     */
    public function keys(): array;

    /**
     * Return all collection elements as array
     * @return array
     */
    public function toArray(): array;

    /**
     * Apply callback on each element and return whole collection object. Modifies original collection items.
     * @param callable $callback
     * @return $this
     * @throws CollectionException
     */
    public function each(callable $callback): static;

    /**
     * Return collection object with items filtered out by callback (value only). Does not modify original collection items.
     * @param callable $callback
     * @return $this
     * @throws CollectionException
     */
    public function filter(callable $callback): static;

    /**
     * Shuffle items in collection. Modifies original collection. Keep the keys unchanged.
     * @return $this
     * @throws CollectionException
     */
    public function shuffle(): static;

    /**
     * Sort items in collection based on provided callback. Modifies original collection. Keep the keys unchanged.
     * @param callable $callback
     * @return $this
     */
    public function sortKeys(callable $callback): static;

    /**
     * Return random item from collection or null if collection is empty
     * @return mixed
     * @throws CollectionException
     */
    public function random(): mixed;

    /**
     * Reset collection items using provided elements
     * @param array $items
     * @return $this
     * @throws CollectionException
     */
    public function reset(array $items = []): static;

    /**
     * Add single item to collection and return updated collection. Modifies original collection.
     * @param mixed $item
     * @param mixed|null $key
     * @return $this
     * @throws CollectionException
     */
    public function add(mixed $item, mixed $key = null): static;

    /**
     * Return single collection element by key. Does not modify original collection.
     * @param mixed $key
     * @return mixed
     * @throws CollectionException
     */
    public function getOne(mixed $key): mixed;

    /**
     * Return copy of collection with elements with keys specified in array $keys (expected format ['key1', 'key2']).
     * Does not modify original collection.
     * @param array $keys
     * @return $this
     * @throws CollectionException
     */
    public function getMany(array $keys): static;

    /**
     * Return single element from collection
     * @param mixed $key
     * @return void
     * @throws CollectionException
     */
    public function removeOne(mixed $key): void;

    /**
     * Remove all elements from collection.
     * @return void
     */
    public function removeAll(): void;

    /**
     * Remove and return first element of collection. Modifies original collection.
     * @return mixed
     * @throws CollectionException
     */
    public function pullFirst(): mixed;

    /**
     * Remove and return last element of collection. Modifies original collection.
     * @return mixed
     * @throws CollectionException
     */
    public function pullLast(): mixed;

    /**
     * Clone collection allowing to modify new collection items without changing original collection items.
     * @return $this
     */
    public function clone(): static;
}
