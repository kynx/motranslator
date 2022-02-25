<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Mock;

use Psr\SimpleCache\CacheInterface;

final class MockCache implements CacheInterface
{
    public const TRANSLATION = 'Mock translation';

    /** @var string  */
    public $key = '';

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        $this->key = $key;

        return self::TRANSLATION;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        return false;
    }
}
