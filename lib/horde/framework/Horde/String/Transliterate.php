<?php
/**
 * Copyright 2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2014 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Util
 */

/**
 * Provides utility methods used to transliterate a string.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2014 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Util
 * @since     2.4.0
 */
class Horde_String_Transliterate
{
    /**
     * Transliterate mapping cache.
     *
     * @var array
     */
    static protected $_map;

    /**
     * Transliterator instance.
     *
     * @var Transliterator
     */
    static protected $_transliterator;

    /**
     * Transliterates an UTF-8 string to ASCII, replacing non-English
     * characters to their English equivalents.
     *
     * Note: there is no guarantee that the output string will be ASCII-only,
     * since any non-ASCII character not in the transliteration list will
     * be ignored.
     *
     * @param string $str  Input string (UTF-8).
     *
     * @return string  Transliterated string (UTF-8).
     */
    static public function toAscii($str)
    {
        switch (true) {
        case class_exists('Transliterator'):
            return self::_intlToAscii($str);
        case extension_loaded('iconv'):
            return self::_iconvToAscii($str);
        default:
            return self::_fallbackToAscii($str);
        }
    }

    /**
     */
    static protected function _intlToAscii($str)
    {
        if (!isset(self::$_transliterator)) {
            self::$_transliterator = Transliterator::create(
                'Any-Latin; Latin-ASCII'
            );
        }
        return self::$_transliterator->transliterate($str);
    }

    /**
     */
    static protected function _iconvToAscii($str)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    }

    /**
     */
    static protected function _fallbackToAscii($str)
    {
        if (!isset(self::$_map)) {
            self::$_map = array(
                '??' => 'A',
                '??' => 'A',
                '??' => 'A',
                '??' => 'A',
                '??' => 'A',
                '??' => 'A',
                '??' => 'AE',
                '??' => 'a',
                '??' => 'a',
                '??' => 'a',
                '??' => 'a',
                '??' => 'a',
                '??' => 'a',
                '??' => 'ae',
                '??' => 'TH',
                '??' => 'th',
                '??' => 'C',
                '??' => 'c',
                '??' => 'D',
                '??' => 'd',
                '??' => 'E',
                '??' => 'E',
                '??' => 'E',
                '??' => 'E',
                '??' => 'e',
                '??' => 'e',
                '??' => 'e',
                '??' => 'e',
                '??' => 'f',
                '??' => 'I',
                '??' => 'I',
                '??' => 'I',
                '??' => 'I',
                '??' => 'i',
                '??' => 'i',
                '??' => 'i',
                '??' => 'i',
                '??' => 'N',
                '??' => 'n',
                '??' => 'O',
                '??' => 'O',
                '??' => 'O',
                '??' => 'O',
                '??' => 'O',
                '??' => 'O',
                '??' => 'o',
                '??' => 'o',
                '??' => 'o',
                '??' => 'o',
                '??' => 'o',
                '??' => 'o',
                '??' => 'S',
                '???' => 'SS',
                '??' => 'ss',
                '??' => 's',
                '??' => 's',
                '??' => 'U',
                '??' => 'U',
                '??' => 'U',
                '??' => 'U',
                '??' => 'u',
                '??' => 'u',
                '??' => 'u',
                '??' => 'Y',
                '??' => 'y',
                '??' => 'y',
                '??' => 'Z',
                '??' => 'z'
            );
        }

        return strtr($str, self::$_map);
    }
}
