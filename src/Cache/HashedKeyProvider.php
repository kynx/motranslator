<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Cache;

final class HashedKeyProvider implements KeyProviderInterface
{
    /** @var string */
    private $prefix;
    /** @var string */
    private $locale;
    /** @var string */
    private $domain;

    public function __construct(string $locale, string $domain, string $prefix = 'mo_')
    {
        $this->locale = $locale;
        $this->domain = $domain;
        $this->prefix = $prefix;
    }

    public function getKey(string $msgid): string
    {
        return $this->prefix . md5($this->locale . $this->domain . $msgid);
    }
}