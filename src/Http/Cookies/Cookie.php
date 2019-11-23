<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Cookies;

use InvalidArgumentException;
use Cardoe\Helper\Arr;
use DateTime;
use DateTimeInterface;
use Exception;
use function array_filter;
use function array_shift;
use function explode;
use function gmdate;
use function implode;
use function is_string;
use function parse_url;
use function preg_match;
use function preg_quote;
use function preg_split;
use function print_r;
use function sprintf;
use function strpos;
use function strtolower;
use function strtotime;
use function substr;
use function time;
use function trim;
use function urlencode;
use function var_dump;
use const PHP_INT_MAX;

/**
 * Class Cookie
 *
 * @package Cardoe\Http\Client\Middleware\Cookie
 *
 * @property string|null $domain;
 * @property bool        $httpOnly
 * @property int         $expires
 * @property int         $maxAge
 * @property string      $name
 * @property string|null $path
 * @property bool        $secure
 * @property string|null $value
 */
class Cookie
{
    /**
     * Cookie domain
     *
     * @var string|null
     */
    private $domain = null;

    /**
     * Use HTTP only or not
     *
     * @var bool
     */
    private $httpOnly = false;

    /**
     * Cookie expiration date in unix epoch seconds
     *
     * @var int
     */
    private $expires = 0;

    /**
     * Cookie max-age
     *
     * @var int
     */
    private $maxAge = 0;

    /**
     * Cookie name
     *
     * @var string
     */
    private $name;

    /**
     * Cookie path
     *
     * @var string|null
     */
    private $path = null;

    /**
     * Use SSL only
     *
     * @var bool
     */
    private $secure = false;

    /**
     * Cookie Value
     *
     * @var string|null
     */
    private $value = null;

    /**
     * Cookie constructor.
     *
     * @param string      $name
     * @param string|null $value
     */
    public function __construct(string $name, ?string $value = null)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * Returns the cookie name and value as a header string
     *
     * @return string
     */
    public function __toString(): string
    {
        $header = [
            urlencode($this->name) . "=" . urlencode((string) $this->value)
        ];

        $header = $this->addPart($header, "domain", "Domain");
        $header = $this->addPart($header, "path", "Path");
        $header = $this->addPart($header, "expires", "Expires");
        $header = $this->addPart($header, "maxAge", "Max-Age");
        $header = $this->addPart($header, "httpOnly", "HttpOnly", true);
        $header = $this->addPart($header, "secure", "Secure", true);

        return implode($header, ";");
    }

    /**
     * Returns the domain or `null`
     *
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Returns if this is http only
     *
     * @return bool
     */
    public function getHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    /**
     * Returns the expires
     *
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * Returns the max age
     *
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->maxAge;
    }

    /**
     * Return the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return the path
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Returns if this is a secure cookie or not
     *
     * @return bool
     */
    public function getSecure(): bool
    {
        return $this->secure;
    }

    /**
     * Returns the value
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return Cookie
     * @throws Exception
     */
    public function expire(): Cookie
    {
        $this->expires = $this->checkExpires(new DateTime("-5 years"));

        return $this;
    }

    /**
     * Try to match a $domain to this cookies domain.
     *
     * @param string $domain
     *
     * @return bool
     */
    protected function isSameDomain(string $domain): bool
    {
        if (empty($this->domain)) {
            return false;
        }

        $cookieDomain = strtolower($this->domain);
        $hostDomain   = strtolower($domain);

        if (substr($cookieDomain, 0, 1) === ".") {
            $cookieDomain = substr($cookieDomain, 1);
        }

        return ($cookieDomain === $hostDomain ||
            preg_match(
                "/\." . preg_quote($cookieDomain) . "$/",
                $hostDomain
            )
        );
    }

    /**
     * Has this cookie expired?
     *
     * @param bool $expire
     *
     * @return bool
     */
    public function isExpired(bool $expire = false): bool
    {
        if (!$this->expires && $expire) {
            return true;
        } elseif (!$this->expires) {
            return false;
        }

        return $this->expires < time();
    }

    /**
     * Match a $scheme, $domain and $path to this cookie object.
     *
     * @param string $scheme
     * @param string $domain
     * @param string $path
     *
     * @return bool
     */
    public function isMatch(string $scheme, string $domain, string $path)
    {
        if (('https' == $scheme && !$this->secure) ||
            ('http'  == $scheme &&  $this->secure)) {
            return false;
        }

        if (!$this->isSameDomain($domain)) {
            return false;
        }

        return ($this->path && 0 === strpos($path, $this->path));
    }

    /**
     * Loads a cookie from a cookie string
     *
     * @param string $cookieString
     * @param string $url
     *
     * @return Cookie
     */
    public function load(string $cookieString, string $url): Cookie
    {
        $this->domain   = null;
        $this->httpOnly = false;
        $this->expires  = 0;
        $this->maxAge   = 0;
        $this->path     = null;
        $this->value    = null;

        $defaults = parse_url($url);

        /**
         * Secure
         */
        $this->secure = (
            "https" === Arr::get($defaults, "scheme", "https", "string")
        );

        /**
         * Path
         */
        $path = Arr::get($defaults, "path", "");
        if (!empty($path)) {
            $this->path = substr(
                $path,
                0,
                strpos($path, "/") + 1
            );
        }

        /**
         * Split cookies
         */
        $cookieList = explode(";", $cookieString);
        $cookieList = array_filter($cookieList);

        /**
         * First element is name and value
         */
        $first = array_shift($cookieList);
        if (empty($first)) {
            throw new InvalidArgumentException(
                "The provided cookie string '' must have at least one attribute"
            );
        }

        list($this->name, $this->value) = Arr::delimit(
            $first,
            "=",
            2,
            "urldecode"
        );

        foreach ($cookieList as $item) {
            list ($property, $value) = Arr::delimit($item, "=", 2, "trim");
            $property = trim(strtolower($property));
            switch ($property) {
                case "domain":
                    $this->setDomain($value);
                    break;
                case "path":
                    $this->setPath($value);
                    break;
                case "expires":
                    $this->setExpires($value);
                    break;
                case "max-age":
                    $this->setMaxAge((int) $value);
                    break;
                case "secure":
                    $this->setSecure(true);
                    break;
                case "httponly":
                    $this->setHttpOnly(true);
                    break;
            }
        }

        return $this;
    }

    /**
     * @return Cookie
     * @throws Exception
     */
    public function rememberForever(): Cookie
    {
        $this->expires = $this->checkExpires(new DateTime("+5 years"));

        return $this;
    }

    /**
     * Return this with the domain set
     *
     * @param string|null $domain
     *
     * @return Cookie
     */
    public function setDomain(?string $domain = null): Cookie
    {
        $this->domain = $this->checkDomain($domain);

        return $this;
    }

    /**
     * Return this with the httpOnly set
     *
     * @param bool $httpOnly
     *
     * @return Cookie
     */
    public function setHttpOnly(bool $httpOnly): Cookie
    {
        $this->httpOnly = $httpOnly;

        return $this;
    }

    /**
     * Return this with the expires set
     *
     * @param mixed $expires
     *
     * @return Cookie
     * @throws InvalidArgumentException
     */
    public function setExpires($expires): Cookie
    {
        $this->expires = $this->checkExpires($expires);

        return $this;
    }

    /**
     * Return this with the expires set
     *
     * @param int $maxAge
     *
     * @return Cookie
     */
    public function setMaxAge(int $maxAge): Cookie
    {
        $this->maxAge = $maxAge;

        return $this;
    }

    /**
     * Return this with the path set
     *
     * @param string|null $path
     *
     * @return Cookie
     */
    public function setPath(?string $path = null): Cookie
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Return this with the secure set
     *
     * @param bool $secure
     *
     * @return Cookie
     */
    public function setSecure(bool $secure): Cookie
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * Return this with the value set
     *
     * @param string|null $value
     *
     * @return Cookie
     */
    public function setValue(?string $value): Cookie
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Appends elements to the array based on present cookie attributes
     *
     * @param array  $header
     * @param string $property
     * @param string $attribute
     * @param bool   $solo
     *
     * @return array
     */
    private function addPart(
        array $header,
        string $property,
        string $attribute,
        bool $solo = false
    ): array {
        if ($this->$property) {
            if ("expires" === $property) {
                $header[] = $attribute . "=" . gmdate('D, d M Y H:i:s T', $this->expires);
            } else {
                $header[] = $attribute . ($solo ? "" : "=" . $this->$property);
            }
        }

        return $header;
    }

    /**
     * @param string $domain
     *
     * @return string
     */
    private function checkDomain(string $domain): string
    {
        if (substr($domain, 0, 1) !== ".") {
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
}
