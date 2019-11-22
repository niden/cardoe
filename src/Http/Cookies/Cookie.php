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
use function is_int;
use function is_numeric;
use function is_string;
use function preg_split;
use function sprintf;
use function strtolower;
use function strtotime;

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
     * @var string|null
     */
    private $domain = null;

    /**
     * @var bool
     */
    private $httpOnly = false;

    /**
     * @var int
     */
    private $expires = 0;

    /**
     * @var int
     */
    private $maxAge = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $path = null;

    /**
     * @var bool
     */
    private $secure = false;

    /**
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
        return $this->withExpires(new DateTime("-5 years"));
    }

    /**
     * Loads a cookie from a cookie string
     *
     * @param string $cookieString
     *
     * @return Cookie
     */
    public function load(string $cookieString): Cookie
    {
        $attributes = $this->splitAttributes($cookieString);
        $attribute  = array_shift($attributes);

        if (!is_string($attribute)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The provided cookie string '%s' must have at least one attribute",
                    $cookieString
                )
            );
        }

        list ($cookieName, $cookieValue) = Arr::delimit(
            $attribute,
            "=",
            2,
            "urldecode"
        );

        $clone = clone($this);

        $clone->name = $cookieName;
        if (null !== $cookieValue) {
            $clone->value = $cookieValue;
        }

        foreach ($attributes as $attribute) {
            list ($property, $value) = Arr::delimit($attribute, "=", 2);
            $property = strtolower($property);
            switch ($property) {
                case "domain":
                case "path":
                    $clone->$property = $value;
                    break;
                case "expires":
                    $clone->$property =  $this->checkExpires($value);
                    break;
                case "max-age":
                    $clone->maxAge = (int) $value;
                    break;
                case "secure":
                    $clone->$property = true;
                    break;
                case "httponly":
                    $clone->httpOnly = true;
                    break;
            }

        }

        return $clone;
    }

    /**
     * @return Cookie
     * @throws Exception
     */
    public function rememberForever(): Cookie
    {
        return $this->withExpires(new DateTime("+5 years"));
    }

    /**
     * Return a new object with the domain set
     *
     * @param string|null $domain
     *
     * @return Cookie
     */
    public function withDomain(?string $domain = null): Cookie
    {
        return $this->performClone("domain", $domain);
    }

    /**
     * Return a new object with the httpOnly set
     *
     * @param bool $httpOnly
     *
     * @return Cookie
     */
    public function withHttpOnly(bool $httpOnly): Cookie
    {
        return $this->performClone("httpOnly", $httpOnly);
    }

    /**
     * Return a new object with the expires set
     *
     * @param mixed $expires
     *
     * @return Cookie
     * @throws InvalidArgumentException
     */
    public function withExpires($expires): Cookie
    {
        $expires = $this->checkExpires($expires);

        return $this->performClone("expires", $expires);
    }

    /**
     * Return a new object with the expires set
     *
     * @param int $maxAge
     *
     * @return Cookie
     */
    public function withMaxAge(int $maxAge): Cookie
    {
        return $this->performClone("maxAge", $maxAge);
    }

    /**
     * Return a new object with the path set
     *
     * @param string|null $path
     *
     * @return Cookie
     */
    public function withPath(?string $path = null): Cookie
    {
        return $this->performClone("path", $path);
    }

    /**
     * Return a new object with the secure set
     *
     * @param bool $secure
     *
     * @return Cookie
     */
    public function withSecure(bool $secure): Cookie
    {
        return $this->performClone("secure", $secure);
    }

    /**
     * Return a new object with the value set
     *
     * @param string|null $value
     *
     * @return Cookie
     */
    public function withValue(?string $value): Cookie
    {
        return $this->performClone("value", $value);
    }

    /**
     * Checks the expires value
     *
     * @param int $expires
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
                sprintf("Invalid expires '%s' provided", $expires)
            );
        }

        return $time;
    }

    /**
     * Clones this object and sets the property
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return Cookie
     */
    private function performClone(string $property, $value): Cookie
    {
        $clone = clone($this);

        $clone->$property = $value;

        return $clone;
    }

    /**
     * @param string $cookieString
     *
     * @return array
     */
    private function splitAttributes(string $cookieString): array
    {
        $splitAttributes = preg_split("@\s*[;]\s*@", $cookieString);

        /**
         * Remove everything with `false`
         */
        return array_filter($splitAttributes);
    }
}
