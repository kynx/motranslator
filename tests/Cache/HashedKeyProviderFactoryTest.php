<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Cache;

use PhpMyAdmin\MoTranslator\Cache\HashedKeyProviderFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PhpMyAdmin\MoTranslator\Cache\HashedKeyProviderFactory
 */
class HashedKeyProviderFactoryTest extends TestCase
{
    public function testGetInstanceUsesDefaultPrefix(): void
    {
        $expected = 'mo_';
        $factory = new HashedKeyProviderFactory();
        $instance = $factory->getInstance('pt_PT', 'foo');

        $actual = $instance->getKey('blah');
        $this->assertStringStartsWith($expected, $actual);
    }

    public function testGetInstanceUsesCustomPrefix(): void
    {
        $expected = 'custom_';
        $factory = new HashedKeyProviderFactory($expected);
        $instance = $factory->getInstance('pt_PT', 'foo');

        $actual = $instance->getKey('blah');
        $this->assertStringStartsWith($expected, $actual);
    }
}
