<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Cookies;

use Cardoe\Collection\Collection;
use Cardoe\Helper\Arr;
use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

use function array_filter;
use function array_map;
use function array_shift;
use function explode;
use function filter_var;
use function gmdate;
use function is_int;
use function is_numeric;
use function ltrim;
use function parse_url;
use function preg_match;
use function preg_quote;
use function rtrim;
use function strlen;
use function strpos;
use function strtolower;
use function strtotime;
use function substr;
use function time;
use function trim;
use function urlencode;

use const FILTER_VALIDATE_IP;

/**
 * Class Cookie
 *
 * @package Cardoe\Http\Client\Middleware\Cookie
 *
 * @property Collection $data
 */
class SetCookie
{
    /**
     * Internal store
     *
     * @var Collection
     */
    private $data = [];

    /**
     * Cookie constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = new Collection($this->getDefaults());
        foreach ($data as $name => $value) {
            $this->data->set($name, $value);
        }

        /**
         * Trigger error for name
         */
        $this->setName($this->getName());

        /**
         * Check the expiration
         */
        if (!$this->getExpires() && $this->getMaxAge()) {
            $this->setExpires(time() + $this->getMaxAge());
        }
    }

    /**
     * Returns the cookie name and value as a header string
     *
     * @return string
     */
    public function __toString(): string
    {
        $result = urlencode($this->getName()) . "="
            . urlencode((string) $this->getValue()) . "; ";

        $data = $this->data->toArray();
        foreach ($data as $name => $value) {
            if (
                "Name" !== $name &&
                "Value" !== $name &&
                null !== $value &&
                false !== $value
            ) {
                if ("Expires" === $name) {
                    $result .= "Expires="
                        . gmdate('D, d M Y H:i:s T', $value) . "; ";
                } else {
                    $result .= (true === $value ? $name : $name . "=" . $value) . "; ";
                }
            }
        }

        return rtrim($result, "; ");
    }

    /**
     * Returns the discard
     *
     * @return bool
     */
    public function getDiscard(): bool
    {
        return (bool) $this->data->get('Discard');
    }

    /**
     * Returns the domain or `null`
     *
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->data->get('Domain');
    }

    /**
     * Returns if this is http only
     *
     * @return bool
     */
    public function getHttpOnly(): bool
    {
        return (bool) $this->data->get('HttpOnly');
    }

    /**
     * Returns the expires
     *
     * @return int
     */
    public function getExpires(): int
    {
        return (int) $this->data->get('Expires');
    }

    /**
     * Returns the max age
     *
     * @return int
     */
    public function getMaxAge(): int
    {
        return (int) $this->data->get('Max-Age');
    }

    /**
     * Return the name
     *
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->data->get('Name');
    }

    /**
     * Return the path
     *
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->data->get('Path');
    }

    /**
     * Returns if this is a secure cookie or not
     *
     * @return bool
     */
    public function getSecure(): bool
    {
        return (bool) $this->data->get('Secure');
    }

    /**
     * Returns the value
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->data->get('Value');
    }

    /**
     * @return SetCookie
     * @throws Exception
     */
    public function expire(): SetCookie
    {
        $this->setExpires(
            $this->checkExpires(new DateTime("-5 years"))
        );

        return $this;
    }

    /**
     * Is the passed domain the same as the cookie domain
     *
     * @param string $domain
     *
     * @return bool
     *
     * @see http://tools.ietf.org/html/rfc6265#section-5.1.3
     * @see http://tools.ietf.org/html/rfc6265#section-5.2.3
     */
    public function isSameDomain(string $domain): bool
    {
        if (empty($this->getDomain())) {
            return false;
        }

        $cookieDomain = ltrim(strtolower($this->getDomain()), '.');
        $hostDomain   = strtolower($domain);

        // Subdomain
        if (filter_var($hostDomain, FILTER_VALIDATE_IP)) {
            return false;
        }

        return ($cookieDomain === $hostDomain ||
            preg_match(
                "/\." . preg_quote($cookieDomain) . "$/",
                $hostDomain
            )
        );
    }

    /**
     * Is the passed path the same as the cookie path
     *
     * Return `true` if:
     * - cookie path = passed path (both lowercase)
     * - cookie path is prefix of passed path - last character is "/"
     * - cookie path is a prefix of the passed path - first character of
     *   the passed path is not included in the cookie path and is "/"
     *
     * @see https://tools.ietf.org/html/rfc6265#section-5.1.3
     *
     * @param string $path
     *
     * @return bool
     */
    public function isSamePath(string $path): bool
    {
        $cookiePath = $this->getPath();

        // Exact and not empty "/"
        if ($cookiePath === "/" || strtolower($cookiePath) == strtolower($path)) {
            return true;
        }

        // Prefix
        if (0 !== strpos($path, $cookiePath)) {
            return false;
        }

        // Last character is "/"
        if (substr($cookiePath, -1, 1) === "/") {
            return true;
        }

        // Prefix - first character not included in cookie path is "/"
        return substr($path, strlen($cookiePath), 1) === "/";
    }

    /**
     * Has this cookie expired?
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return 0 !== $this->getExpires() && $this->getExpires() < time();
    }

    /**
     * Loads a cookie from a cookie string
     *
     * @param string $cookieString
     * @param string $url
     *
     * @return SetCookie
     */
    public function load(string $cookieString, string $url): SetCookie
    {
        $this->data->init($this->getDefaults());

        $defaults = parse_url($url);

        /**
         * Secure
         */
        $this->setSecure(
            "https" === Arr::get(
                $defaults,
                "scheme",
                "https",
                "string"
            )
        );

        /**
         * Path
         */
        $path = Arr::get($defaults, "path", "/");
        if ("/" !== $path && !empty($path)) {
            $this->setPath(
                substr(
                    $path,
                    0,
                    strpos($path, "/") + 1
                )
            );
        }

        /**
         * Split cookies
         */
        $list = array_filter(
            array_map("trim", explode(";", $cookieString))
        );

        /**
         * First element is name and value
         */
        $first = array_shift($list);
        if (empty($first)) {
            throw new InvalidArgumentException(
                "The provided cookie string '{$cookieString}' " .
                "must have at least one attribute"
            );
        }

        [$name, $value] = Arr::delimit(
            $first,
            "=",
            2,
            "urldecode"
        );

        $this
            ->setName($name)
            ->setValue($value)
        ;

        foreach ($list as $item) {
            [$property, $value] = Arr::delimit($item, "=");
            $property = trim(strtolower($property));
            $value    = is_string($value) ? trim($value, " \n\r\t\0\x0B") : $value;
            switch ($property) {
                case "discard":
                    $this->setDiscard(true);
                    break;
                case "domain":
                    $this->setDomain($value);
                    break;
                case "expires":
                    $this->setExpires($value);
                    break;
                case "httponly":
                    $this->setHttpOnly(true);
                    break;
                case "max-age":
                    $this->setMaxAge((int) $value);
                    break;
                case "path":
                    $this->setPath($value);
                    break;
                case "secure":
                    $this->setSecure(true);
                    break;
            }
        }

        return $this;
    }

    /**
     * Set the cookie to remember forever
     *
     * @return SetCookie
     * @throws Exception
     */
    public function rememberForever(): SetCookie
    {
        $this->setExpires(
            $this->checkExpires(new DateTime("+5 years"))
        );

        return $this;
    }

    /**
     * Return this with the Discard set
     *
     * @param bool $discard
     *
     * @return SetCookie
     */
    public function setDiscard(bool $discard): SetCookie
    {
        $this->data->set('Discard', $discard);

        return $this;
    }

    /**
     * Return this with the domain set
     *
     * @param string|null $domain
     *
     * @return SetCookie
     */
    public function setDomain(?string $domain = null): SetCookie
    {
        $this->data->set(
            'Domain',
            $this->checkDomain($domain)
        );

        return $this;
    }

    /**
     * Return this with the expires set
     *
     * @param mixed $expires
     *
     * @return SetCookie
     * @throws InvalidArgumentException
     */
    public function setExpires($expires): SetCookie
    {
        $this->data->set('Expires', $this->checkExpires($expires));

        return $this;
    }

    /**
     * Return this with the httpOnly set
     *
     * @param bool $httpOnly
     *
     * @return SetCookie
     */
    public function setHttpOnly(bool $httpOnly): SetCookie
    {
        $this->data->set('HttpOnly', $httpOnly);

        return $this;
    }

    /**
     * Return this with the max-age set
     *
     * @param int $maxAge
     *
     * @return SetCookie
     */
    public function setMaxAge(int $maxAge): SetCookie
    {
        $this->data->set('Max-Age', $maxAge);

        return $this;
    }

    /**
     * Return this with the name set
     *
     * @param string $name
     *
     * @return SetCookie
     */
    public function setName(string $name): SetCookie
    {
        $this->data->set('Name', $this->checkName($name));

        return $this;
    }

    /**
     * Return this with the path set
     *
     * @param string $path
     *
     * @return SetCookie
     */
    public function setPath(string $path = "/"): SetCookie
    {
        $this->data->set('Path', $path);

        return $this;
    }

    /**
     * Return this with the secure set
     *
     * @param bool $secure
     *
     * @return SetCookie
     */
    public function setSecure(bool $secure): SetCookie
    {
        $this->data->set('Secure', $secure);

        return $this;
    }

    /**
     * Return this with the value set
     *
     * @param string $value
     *
     * @return SetCookie
     */
    public function setValue(?string $value): SetCookie
    {
        $this->data->set('Value', $value);

        return $this;
    }

    /**
     * Checks the name
     *
     * @param string $name
     *
     * @return string
     */
    private function checkName(string $name): string
    {
        if (empty($name) && !is_numeric($name)) {
            throw new InvalidArgumentException(
                "The cookie name cannot be empty"
            );
        }

        // RFC-6265
        if (
            preg_match(
                '/[\x00-\x20\x22\x28-\x29\x2c\x2f\x3a-\x40{\x7d\x7f]/',
                $name
            )
        ) {
            throw new InvalidArgumentException(
                "The cookie name cannot contain invalid characters: " .
                " ASCII (0-31;127), space, tab and ()<>@,;:\"/?={}';"
            );
        }

        return $name;
    }

    /**
     * Checks the domain
     *
     * @param string $domain
     *
     * @return string
     */
    private function checkDomain(?string $domain): ?string
    {
        if (!empty($domain) && substr($domain, 0, 1) !== ".") {
            $domain = "." . $domain;
        }

        return $domain;
    }

    /**
     * Checks the expires value
     *
     * @param mixed $expires
     *
     * @return int
     * @throws InvalidArgumentException
     */
    private function checkExpires($expires): int
    {
        if ($expires instanceof DateTimeInterface) {
            return $expires->getTimestamp();
        }

        if (is_numeric($expires)) {
            return (int) $expires;
        }

        $time = strtotime($expires);

        if (!is_int($time)) {
            throw new InvalidArgumentException(
                "Invalid expires '" . $expires . "' provided"
            );
        }

        return $time;
    }

    /**
     * Returns default values
     *
     * @return array
     */
    private function getDefaults(): array
    {
        return [
            "Discard"  => false,
            "Domain"   => null,
            "Expires"  => null,
            "HttpOnly" => false,
            "Max-Age"  => null,
            "Name"     => null,
            "Path"     => null,
            "Secure"   => false,
            "Value"    => null,
        ];
    }
}
