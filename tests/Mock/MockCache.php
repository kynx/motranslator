<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Mock;

use Psr\SimpleCache\CacheInterface;

final class MockCache implements CacheInterface
{
    public const TRANSLATION = 'Mock translation';

    public $key = '';

    public function get($key, $default = null)
    {
        $this->key = $key;
        return self::TRANSLATION;
    }

    public function set($key, $value, $ttl = null)
    {
        return false;
    }

    public function delete($key)
    {
        return false;
    }

    public function clear()
    {
        return false;
    }

    public function getMultiple($keys, $default = null)
    {
        return [];
    }

    public function setMultiple($values, $ttl = null)
    {
        return false;
    }

    public function deleteMultiple($keys)
    {
        return false;
    }

    public function has($key)
    {
        return false;
    }
}