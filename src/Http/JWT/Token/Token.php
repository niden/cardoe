<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT\Token;

/**
 * Class Token
 *
 * @property Item      $claims
 * @property Item      $jose
 * @property Signature $signature
 *
 * @link https://tools.ietf.org/html/rfc7519
 */
class Token
{
    /**
     * @var Item
     */
    private $claims;

    /**
     * @var Item
     */
    private $jose;

    /**
     * @var Signature
     */
    private $signature;

    /**
     * Token constructor.
     *
     * @param Item      $jose
     * @param Item      $claims
     * @param Signature $signature
     */
    public function __construct(
        Item $jose,
        Item $claims,
        Signature $signature
    ) {
        $this->jose      = $jose;
        $this->claims    = $claims;
        $this->signature = $signature;
    }

    /**
     * @return array
     */
    public function getClaims(): array
    {
        return $this->claims->getPayload();
    }
    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->jose->getPayload();
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->jose->getEncoded() . "." . $this->claims->getEncoded();
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature->getEncoded();
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->getPayload() . "."  . $this->getSignature();
    }

    /**
     * @param string $audience
     *
     * @return bool
     */
    public function isForAudience(string $audience): bool
    {
        return in_array($audience, $this->claims->get(Enum::AUDIENCE, []));
    }

    /**
     * @param int $timestamp
     *
     * @return bool
     */
    public function isExpired(int $timestamp): bool
    {
        if (!$this->claims->has(Enum::EXPIRATION_TIME)) {
            return false;
        }

        return $timestamp > (int) $this->claims->get(Enum::EXPIRATION_TIME);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isIdentifiedBy(string $id): bool
    {
        return $id === (string) $this->claims->get(Enum::ID);
    }

    /**
     * @param int $timestamp
     *
     * @return bool
     */
    public function isIssuedBefore(int $timestamp): bool
    {
        return $timestamp >= (int) $this->claims->get(Enum::ISSUED_AT);
    }

    /**
     * @param string $issuer
     *
     * @return bool
     */
    public function isIssuedBy(string $issuer): bool
    {
        return $issuer === (string) $this->claims->get(Enum::ISSUER);
    }

    /**
     * @param int $timestamp
     *
     * @return bool
     */
    public function isIssuedNotBefore(int $timestamp): bool
    {
        return $timestamp >= (int) $this->claims->get(Enum::NOT_BEFORE);
    }
}
