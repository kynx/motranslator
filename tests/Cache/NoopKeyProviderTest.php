<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Cache;

use PhpMyAdmin\MoTranslator\Cache\NoopKeyProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PhpMyAdmin\MoTranslator\Cache\NoopKeyProvider
 */
class NoopKeyProviderTest extends TestCase
{
    public function testGetKeyReturnsKeyUnchanged(): void
    {
        $expected = 'blah blah';
        $keyProvider = new NoopKeyProvider();
        $actual = $keyProvider->getKey($expected);
        $this->assertSame($expected, $actual);
    }
}
