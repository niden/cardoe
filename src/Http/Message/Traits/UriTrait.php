<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message\Traits;

use Cardoe\Helper\Str;

/**
 * PSR-7 Uri
 *
 * @package Cardoe\Http\Message
 */
trait UriTrait
{
    /**
     * Retrieve the fragment component of the URI.
     *
     * @var string
     */
    private $fragment = '';
    /**
     * Retrieve the path component of the URI.
     *
     * @var string
     */
    private $path = '';

    /**
     * Retrieve the query string of the URI.
     *
     * @var string
     */
    private $query = '';

    /**
     * @var string
     */
    private $scheme = 'https';

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters
     *
     * @return string
     */
    public function __toString(): string
    {
        $authority = $this->getAuthority();
        $path      = $this->path;

        /**
         * The path can be concatenated without delimiters. But there are two
         * cases where the path has to be adjusted to make the URI reference
         * valid as PHP does not allow to throw an exception in __toString():
         *   - If the path is rootless and an authority is present, the path
         *     MUST be prefixed by "/".
         *   - If the path is starting with more than one "/" and no authority
         *     is present, the starting slashes MUST be reduced to one.
         */
        if ('' !== $path && true !== Str::startsWith($path, '/') && '' !== $authority) {
            $path = '/' . $path;
        }

        $uri = $this->checkValue($this->scheme, '', ':')
            . $this->checkValue($authority, '//')
            . $path
            . $this->checkValue($this->query, '?')
            . $this->checkValue($this->fragment, '#');

        return $uri;
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @return string
     */
    abstract public function getAuthority(): string;

    /**
     * If the value passed is empty it returns it prefixed and suffixed with
     * the passed parameters
     *
     * @param string $value
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    private function checkValue(string $value, string $prefix = '', string $suffix = ''): string
    {
        if ('' !== $value) {
            $value = $prefix . $value . $suffix;
        }

        return $value;
    }
}
