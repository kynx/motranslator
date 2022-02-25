<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Cache;

use PhpMyAdmin\MoTranslator\Cache\InMemoryCache;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PhpMyAdmin\MoTranslator\Cache\InMemoryCache
 */
class InMemoryCacheTest extends TestCase
{
    public function testGetReturnsItem(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar']);
        $actual = $cache->get('foo');
        $this->assertSame('bar', $actual);
    }

    public function testGetReturnsDefault(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar']);
        $actual = $cache->get('baz', 'default');
        $this->assertSame('default', $actual);
    }

    public function testSet(): void
    {
        $cache = new InMemoryCache();
        $cache->set('foo', 'bar');
        $actual = $cache->getAll();
        $this->assertSame(['foo' => 'bar'], $actual);
    }

    public function testDelete(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar']);
        $cache->delete('foo');
        $actual = $cache->getAll();
        $this->assertSame([], $actual);
    }

    public function testClear(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar', 'and' => 'another']);
        $cache->clear();
        $actual = $cache->getAll();
        $this->assertSame([], $actual);
    }

    public function testGetMultiple(): void
    {
        $expected = ['and' => 'another', 'yet' => 'more'];
        $cache = new InMemoryCache(['foo' => 'bar', 'and' => 'another', 'yet' => 'more']);
        $actual = $cache->getMultiple(['and', 'yet']);
        $this->assertSame($expected, $actual);
    }

    public function testGetMultipleReturnsDefaults(): void
    {
        $expected = ['and' => 'foo', 'yet' => 'foo'];
        $cache = new InMemoryCache();
        $actual = $cache->getMultiple(['and', 'yet'], 'foo');
        $this->assertSame($expected, $actual);
    }

    public function testSetMultiple(): void
    {
        $expected = ['foo' => 'bar', 'and' => 'another'];
        $cache = new InMemoryCache();
        $cache->setMultiple($expected);
        $actual = $cache->getAll();
        $this->assertSame($expected, $actual);
    }

    public function testDeleteMultiple(): void
    {
        $expected = ['foo' => 'bar'];
        $cache = new InMemoryCache(['foo' => 'bar', 'and' => 'another', 'yet' => 'more']);
        $cache->deleteMultiple(['and', 'yet']);
        $actual = $cache->getAll();
        $this->assertSame($expected, $actual);
    }

    public function testHasReturnsTrue(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar']);
        $actual = $cache->has('foo');
        $this->assertTrue($actual);
    }

    public function testHasReturnsFalse(): void
    {
        $cache = new InMemoryCache(['foo' => 'bar']);
        $actual = $cache->has('baz');
        $this->assertFalse($actual);
    }

    public function testGetAll(): void
    {
        $expected = ['foo' => 'bar', 'and' => 'another'];
        $cache = new InMemoryCache($expected);
        $actual = $cache->getAll();
        $this->assertSame($expected, $actual);
    }

    public function testSetAll(): void
    {
        $expected = ['foo' => 'bar', 'and' => 'another'];
        $cache = new InMemoryCache();
        $cache->setAll($expected);
        $actual = $cache->getAll();
        $this->assertSame($expected, $actual);
    }
}
