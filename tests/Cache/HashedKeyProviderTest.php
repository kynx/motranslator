<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Cache;

use PhpMyAdmin\MoTranslator\Cache\HashedKeyProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PhpMyAdmin\MoTranslator\Cache\HashedKeyProvider
 */
class HashedKeyProviderTest extends TestCase
{
    public function testGetKeyReturnsPrefixedKey(): void
    {
        $locale = 'pt_PT';
        $domain = 'foo';
        $msgid = 'Blah blah';
        $expected = 'mo_' . md5($locale . $domain . $msgid);
        $keyProvider = new HashedKeyProvider($locale, $domain);

        $actual = $keyProvider->getKey($msgid);
        $this->assertSame($expected, $actual);
    }

    public function testGetKeyUsesCustomPrefix(): void
    {
        $expected = 'custom_';
        $keyProvider = new HashedKeyProvider('pt_PT', 'foo', $expected);

        $actual = $keyProvider->getKey('Blah blah');
        $this->assertStringStartsWith($expected, $actual);
    }
}
