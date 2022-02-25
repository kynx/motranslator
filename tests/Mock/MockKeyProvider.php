<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Mock;

use PhpMyAdmin\MoTranslator\Cache\KeyProviderInterface;

final class MockKeyProvider implements KeyProviderInterface
{
    public const KEY = 'mock-key';

    public function getKey(string $msgid): string
    {
        return self::KEY;
    }
}
