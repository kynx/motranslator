<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

interface KeyProviderInterface
{
    public function getKey(string $msgid): string;
}
