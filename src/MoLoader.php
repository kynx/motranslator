<?php
/*
    Copyright (c) 2005 Steven Armstrong <sa at c-area dot ch>
    Copyright (c) 2009 Danilo Segan <danilo@kvota.net>
    Copyright (c) 2016 Michal Čihař <michal@cihar.com>

    This file is part of MoTranslator.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace MoTranslator;

class MoLoader {
    /**
     * Loader instance
     *
     * @access private
     * @static
     * @var MoLoader
     */
    private static $_instance;

    /**
     * @var string Default gettext domain to use.
     */
    private $default_domain = '';

    /**
     * @var string Configured locale.
     */
    private $locale = '';

    /**
     * @var array Loaded domains
     */
    private $domains = array();

    /**
     * @var array Bound paths for domains
     */
    private $paths = array('' => './');

    /**
     * Returns the singleton Response object
     *
     * @return Response object
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new MoLoader();
        }
        return self::$_instance;
    }

    /**
     * Figure out all possible locale names and start with the most
     * specific ones.  I.e. for sr_CS.UTF-8@latin, look through all of
     * sr_CS.UTF-8@latin, sr_CS@latin, sr@latin, sr_CS.UTF-8, sr_CS, sr.
     *
     * @param string $locale Locale code
     *
     * @return array list of locales to try for any POSIX-style locale specification.
     */
    static public function list_locales($locale) {
        $locale_names = array();

        $lang = NULL;
        $country = NULL;
        $charset = NULL;
        $modifier = NULL;

        if ($locale) {
            if (preg_match("/^(?P<lang>[a-z]{2,3})"              // language code
                ."(?:_(?P<country>[A-Z]{2}))?"           // country code
                ."(?:\.(?P<charset>[-A-Za-z0-9_]+))?"    // charset
                ."(?:@(?P<modifier>[-A-Za-z0-9_]+))?$/",  // @ modifier
                $locale, $matches)) {

                extract($matches);

                if ($modifier) {
                    if ($country) {
                        if ($charset) {
                            array_push($locale_names, "${lang}_$country.$charset@$modifier");
                        }
                        array_push($locale_names, "${lang}_$country@$modifier");
                    } elseif ($charset)
                        array_push($locale_names, "${lang}.$charset@$modifier");
                        array_push($locale_names, "$lang@$modifier");
                    }
                if ($country) {
                    if ($charset) {
                        array_push($locale_names, "${lang}_$country.$charset");
                    }
                    array_push($locale_names, "${lang}_$country");
                } elseif ($charset) {
                    array_push($locale_names, "${lang}.$charset");
                }
                array_push($locale_names, $lang);
            }

            // If the locale name doesn't match POSIX style, just include it as-is.
            if (!in_array($locale, $locale_names)) {
                array_push($locale_names, $locale);
            }
        }
        return $locale_names;
    }

    public function get_translator($domain='')
    {
        if (empty($domain)) {
            $domain = $this->default_domain;
        }

        if (!isset($this->domains[$domain])) {

            if (isset($this->paths[$domain])) {
                $base = $this->paths[$domain];
            } else {
                $base = './';
            }

            $locale_names = $this->list_locales($this->locale);

            foreach ($locale_names as $locale) {
                $full_path = "$base/$locale/LC_MESSAGES/$domain.mo";
                if (file_exists($full_path)) {
                    break;
                }
            }

            // We don't care about invalid path, we will get fallback
            // translator here
            $this->domains[$domain] = new MoTranslator($full_path);
        }

        return $this->domains[$domain];
    }

    public function bindtextdomain($domain, $path)
    {
        $this->paths[$domain] = $path;
    }

    public function textdomain($domain)
    {
        $this->default_domain = $domain;
    }

    public function setlocale($locale)
    {
        $this->locale = $locale;
        // Set system locales as well
        if (function_exists('setlocale')) {
            setlocale(LC_MESSAGES, $locale);
        }
    }
}