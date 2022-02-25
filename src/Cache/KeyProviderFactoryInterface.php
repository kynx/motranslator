<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

interface KeyProviderFactoryInterface
{
    public function getInstance(string $locale, string $domain): KeyProviderInterface;
}
