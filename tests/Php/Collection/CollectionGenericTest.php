<?php

namespace Tests\Php\Collection;

use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Php\Collection\CollectionGeneric;
use PHPUnit\Framework\TestCase;

class CollectionGenericTest extends TestCase
{
    private CollectionGeneric $collectionEmpty;
    private CollectionGeneric $collection;
    private array $items;

    public function setUp(): void
    {
        $this->items = ['A' => 1, 'B' => 2, 'C' => 3];
        $this->collectionEmpty = new CollectionGeneric();
        $this->collection = new CollectionGeneric($this->items);
    }

    public function testCount(): void
    {
        $this->assertEquals(0, $this->collectionEmpty->count());
        $this->assertEquals(count($this->items), $this->collection->count());
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue($this->collectionEmpty->isEmpty());
        $this->assertFalse($this->collection->isEmpty());
    }

    public function testExist(): void
    {
        $this->assertTrue($this->collection->exist(array_keys($this->items)[0]));
        $this->assertFalse($this->collection->exist('definitely-missing-elements-key-AB987'));
    }

    public function testToArray(): void
    {
        $itemsAdd = array_merge($this->items, [4]);
        $collectionAdd = new CollectionGeneric($itemsAdd);

        $this->assertSame($this->items, $this->collection->toArray());
        $this->assertSame(array_values($itemsAdd), array_values($collectionAdd->toArray()));
        $this->assertSame([], $this->collectionEmpty->toArray());
    }

    public function testEach(): void
    {
        $callback = fn($item) => $item * 2;
        $callbackItems = array_map($callback, $this->items);
        $callbackCollection = $this->collection->each($callback);

        $this->assertSame($callbackItems, $callbackCollection->toArray());
        $this->assertSame($this->collection->toArray(), $callbackCollection->toArray());
        $this->assertSame([], $this->collectionEmpty->each($callback)->toArray());
    }

    public function testFilter(): void
    {
        $callbackValue = fn($item) => $item > 1;
        $callbackValueItems = array_filter($this->items, $callbackValue);
        $callbackValueCollection = $this->collection->filter($callbackValue);

        $callbackKey = fn($item, $key) => $key === array_keys($this->items)[0];
        $callbackKeyItems = array_filter($this->items, $callbackKey, ARRAY_FILTER_USE_BOTH);
        $callbackKeyCollection = $this->collection->filter($callbackKey);

        $this->assertSame($callbackValueItems, $callbackValueCollection->toArray());
        $this->assertNotSame($this->collection->toArray(), $callbackValueCollection->toArray());
        $this->assertSame([], $this->collectionEmpty->filter($callbackValue)->toArray());

        $this->assertSame($callbackKeyItems, $callbackKeyCollection->toArray());
        $this->assertNotSame($this->collection->toArray(), $callbackKeyCollection->toArray());
        $this->assertSame([], $this->collectionEmpty->filter($callbackKey)->toArray());
    }

    public function testShuffle(): void
    {
        $shuffled = false;
        for ($i = 0; $i < 100; $i++) {
            $shuffledCollection = $this->collection->shuffle();
            if ($this->collection->toArray() !== array_values($this->items)) {
                $shuffled = true;
                break;
            }
        }

        $this->collectionEmpty->shuffle();

        $this->assertTrue($shuffled);
        $this->assertSame($shuffledCollection->toArray(), $this->collection->toArray());
        $this->assertTrue($this->collection->exist(array_keys($this->items)[0]));
        $this->assertSame([], $this->collectionEmpty->toArray());
    }

    public function testRandom(): void
    {
        $different = false;
        for ($i = 0; $i < 100; $i++) {
            if ($this->collection->random() !== $this->collection->random()) {
                $different = true;
                break;
            }
        }

        $this->assertTrue($different);
        $this->assertNull($this->collectionEmpty->random());
    }

    public function testAssignKeys(): void
    {
        $this->collection->assignKeys(fn($item) => $item * 2);
        $this->collectionEmpty->assignKeys(fn($item) => $item * 2);

        $this->assertEquals(1, $this->collection->getOne(2));
        $this->assertEquals(2, $this->collection->getOne(4));
        $this->assertEquals(3, $this->collection->getOne(6));
        $this->assertSame([], $this->collectionEmpty->toArray());
    }

    public function testAssignKeysWithDuplicateKeys(): void
    {
        $this->collection->assignKeys(fn($item) => 'dummy-key');
        $this->assertEquals(1, $this->collection->count());
    }

    public function testReset(): void
    {
        $this->collection->reset(['A' => 1, 'B' => 2]);
        $this->assertEquals(['A' => 1, 'B' => 2], $this->collection->toArray());
    }

    public function testAddThrowExceptionForDuplicatedKey(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $key = array_keys($this->items)[0];
        $this->collection->add($this->items[$key], $key);
    }

    public function testAdd(): void
    {
        $this->assertTrue($this->collection->add(4, 'D')->exist('D'));
        $this->assertEquals(5, $this->collection->add(5)->count());
        $this->assertEquals(6, $this->collection->add(6, 0)->count());
    }

    public function testGetOneThrowExceptionWithMissingKey(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_MISSING_KEY);

        $this->collection->getOne('definitely-missing-key-AC(*&S');
    }

    public function testGetOne(): void
    {
        $key = array_keys($this->items)[0];
        $this->assertSame($this->items[$key], $this->collection->getOne($key));
    }

    public function testRemoveOneThrowExceptionWithMissingKey(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_MISSING_KEY);

        $this->collection->RemoveOne('definitely-missing-key-AC(*&S');
    }

    public function testRemoveOne(): void
    {
        $key = array_keys($this->items)[0];
        $this->collection->removeOne($key);

        $this->assertFalse($this->collection->exist($key));
        $this->assertEquals(count($this->items) - 1, $this->collection->count());
    }

    public function testRemoveAll(): void
    {
        $this->collection->removeAll();
        $this->assertEquals(0, $this->collection->count());
    }

    public function testPullFirstThrowExceptionIfCollectionEmpty(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_NO_ELEMENTS);

        $this->collectionEmpty->pullFirst();
    }

    public function testPullFirst(): void
    {
        $this->assertEquals(1, $this->collection->pullFirst());
        $this->assertEquals(['B' => 2, 'C' => 3], $this->collection->toArray());
    }

    public function testPullLastThrowExceptionIfCollectionEmpty(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_NO_ELEMENTS);

        $this->collectionEmpty->pullLast();
    }

    public function testPullLast(): void
    {
        $this->assertEquals(3, $this->collection->pullLast());
        $this->assertEquals(['A' => 1, 'B' => 2], $this->collection->toArray());
    }

    public function testClone(): void
    {
        $clone = $this->collection->clone();
        $clone->reset();

        $this->assertEquals(0, $clone->count());
        $this->assertEquals(count($this->items), $this->collection->count());
    }
}
