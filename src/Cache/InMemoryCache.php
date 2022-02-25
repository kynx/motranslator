<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

use Psr\SimpleCache\CacheInterface;

use function array_key_exists;

/**
 * Simplistic in-memory cache
 *
 * This does not honour PSR-16's requirements for TTL or invalid cache key characters. It is for internal use only.
 *
 * @internal
 */
final class InMemoryCache implements CacheInterface
{
    /** @var string[]  */
    private $items;

    /**
     * @param string[]|null $items
     */
    public function __construct(?array $items = null)
    {
        $this->items = $items ?? [];
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null): bool
    {
        $this->items[$key] = $value;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete($key): bool
    {
        unset($this->items[$key]);

        return true;
    }

    public function clear(): bool
    {
        $this->items = [];

        return true;
    }

    /**
     * @param string[]    $keys
     * @param string|null $default
     *
     * @return string[]
     */
    public function getMultiple($keys, $default = null): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->get($key, $default);
        }

        return $items;
    }

    /**
     * @param string[] $values
     *
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @param string[] $keys
     *
     * @inheritDoc
     */
    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Returns all items from cache
     *
     * @return string[]
     */
    public function getAll(): array
    {
        return $this->items;
    }

    /**
     * Warms cache with given items
     *
     * @param string[] $items
     */
    public function setAll(array $items): void
    {
        $this->items = $items;
    }
}
