<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Helper;

use function preg_replace;
use function rtrim;

use const DIRECTORY_SEPARATOR;

/**
 * Phalcon\Helper\Fs
 *
 * This class offers quick file system functions throughout the framework
 */
class Fs
{
    /**
     * Gets the filename from a given path, Same as PHP's basename() but has
     * non-ASCII support. PHP's basename() does not properly support streams or
     * filenames beginning with a non-US-ASCII character.
     *
     * @see https://bugs.php.net/bug.php?id=37738
     *
     * @param string $uri
     * @param string $suffix
     *
     * @return string
     */
    final public static function basename(string $uri, string $suffix = null): string
    {
        $uri      = rtrim($uri, DIRECTORY_SEPARATOR);
        $filename = preg_match(
            "@[^" . preg_quote(DIRECTORY_SEPARATOR, "@") . "]+$@",
            $uri,
            $matches
        ) ? $matches[0] : "";

        if ($suffix) {
            $filename = preg_replace(
                "@" . preg_quote($suffix, "@") . "$@",
                "",
                $filename
            );
        }

        return $filename;
    }
}
