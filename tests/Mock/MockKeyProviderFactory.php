<?php

declare(strict_types=1);

namespace PhpMyAdmin\MoTranslator\Tests\Mock;

use PhpMyAdmin\MoTranslator\Cache\KeyProviderFactoryInterface;
use PhpMyAdmin\MoTranslator\Cache\KeyProviderInterface;

final class MockKeyProviderFactory implements KeyProviderFactoryInterface
{
    /** @var string|null  */
    public $locale = null;
    /** @var string|null  */
    public $domain = null;

    public function getInstance(string $locale, string $domain): KeyProviderInterface
    {
        $this->locale = $locale;
        $this->domain = $domain;

        return new MockKeyProvider();
    }
}
