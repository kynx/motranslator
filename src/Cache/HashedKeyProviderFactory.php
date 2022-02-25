<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

final class HashedKeyProviderFactory implements KeyProviderFactoryInterface
{
    /** @var string */
    private $prefix;

    public function __construct(string $prefix = 'mo_')
    {
        $this->prefix = $prefix;
    }

    public function getInstance(string $locale, string $domain): KeyProviderInterface
    {
        return new HashedKeyProvider($locale, $domain, $this->prefix);
    }
}