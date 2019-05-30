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
use Cardoe\Http\Message\Exception\InvalidArgumentException;
use function array_keys;
use function explode;
use function implode;
use function ltrim;
use function preg_replace;
use function rawurlencode;

/**
 * PSR-7 Uri
 *
 * @package Cardoe\Http\Message
 */
trait UriTrait
{
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

    /**
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     *
     * @param string $fragment
     *
     * @return string
     */
    private function filterFragment(string $fragment): string
    {
        return rawurlencode($fragment);
    }

    /**
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     *
     * @param string $path
     *
     * @return string The URI path.
     */
    private function filterPath(string $path): string
    {
        if ('' === $path || true !== Str::startsWith($path, '/')) {
            return $path;
        }

        $parts = explode('/', $path);
        foreach ($parts as $key => $element) {
            $parts[$key] = rawurlencode($element);
        }

        $path = implode('/', $parts);

        return '/' . ltrim($path, '/');
    }

    /**
     * Checks the port. If it is a standard one (80,443) then it returns null
     *
     * @param $port
     *
     * @return int|null
     */
    private function filterPort($port): ?int
    {
        $ports = [
            80  => 1,
            443 => 1,
        ];

        if (null !== $port) {
            $port = (int) $port;
            if (true === isset($ports[$port])) {
                $port = null;
            }
        }

        return $port;
    }

    /**
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @param string $query
     *
     * @return string The URI query string.
     */
    private function filterQuery(string $query): string
    {
        if ('' === $query) {
            return '';
        }

        $query = ltrim($query, '?');
        $parts = explode("&", $query);
        foreach ($parts as $index => $part) {
            [$key, $value] = $this->splitQueryValue($part);
            if (null === $value) {
                $parts[$index] = rawurlencode($key);

                continue;
            }

            $parts[$index] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return implode('&', $parts);
    }

    /**
     * Filters the passed scheme - only allowed schemes
     *
     * @param string $scheme
     *
     * @return string
     */
    private function filterScheme(string $scheme): string
    {
        $filtered = preg_replace(
            '#:(//)?$#',
            '',
            mb_strtolower($scheme)
        );
        $schemes  = [
            'http'  => 1,
            'https' => 1,
        ];

        if ('' === $filtered) {
            return '';
        }

        if (true !== isset($schemes[$filtered])) {
            throw new InvalidArgumentException(
                "Unsupported scheme [" . $filtered . "]. " .
                "Scheme must be one of [" .
                implode(", ", array_keys($schemes)) . "]"
            );
        }

        return $scheme;
    }

    /**
     * @param string $element
     *
     * @return array
     */
    private function splitQueryValue(string $element): array
    {
        $data = explode('=', $element, 2);
        if (true !== isset($data[1])) {
            $data[] = null;
        }

        return $data;
    }
}