<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

/**
 * `KeyProviderInterface` that just returns `$msgid` unchanged
 *
 * @internal
 */
final class NoopKeyProvider implements KeyProviderInterface
{
    public function getKey(string $msgid): string
    {
        return $msgid;
    }
}
