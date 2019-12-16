<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT;

use Phalcon\Http\JWT\Encoder\EncoderInterface;
use Phalcon\Http\JWT\Exceptions\ValidateException;

/**
 * Class Builder
 *
 * @property array            $claims
 * @property array            $jose
 * @property string           $passphrase
 * @property EncoderInterface $signer
 *
 * @link https://tools.ietf.org/html/rfc7519
 */
class Builder
{
    /**
     * @var array
     */
    private $claims;

    /**
     * @var array
     */
    private $jose;

    /**
     * @var string
     */
    private $passphrase;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @return mixed|null
     */
    public function getAudience()
    {
        return $this->claims["aud"] ?? null;
    }

    /**
     * @return int|null
     */
    public function getExpirationTime(): ?int
    {
        return $this->claims["exp"] ?? null;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->claims["jti"] ?? null;
    }

    /**
     * @return int|null
     */
    public function getIssuedAt(): ?int
    {
        return $this->claims["iat"] ?? null;
    }

    /**
     * @return string|null
     */
    public function getIssuer(): ?string
    {
        return $this->claims["iss"] ?? null;
    }

    /**
     * @return int|null
     */
    public function getNotBefore(): ?int
    {
        return $this->claims["nbf"] ?? null;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->claims["sub"] ?? null;
    }

    /**
     * @return Builder
     */
    public function init(): Builder
    {
        $this->claims = [];
        $this->jose   = [
            "typ" => "JTT",
            "alg" => "none",
        ];

        return $this;
    }

    /**
     * The "aud" (audience) claim identifies the recipients that the JWT is
     * intended for.  Each principal intended to process the JWT MUST
     * identify itself with a value in the audience claim.  If the principal
     * processing the claim does not identify itself with a value in the
     * "aud" claim when this claim is present, then the JWT MUST be
     * rejected.  In the general case, the "aud" value is an array of case-
     * sensitive strings, each containing a StringOrURI value.  In the
     * special case when the JWT has one audience, the "aud" value MAY be a
     * single case-sensitive string containing a StringOrURI value.  The
     * interpretation of audience values is generally application specific.
     * Use of this claim is OPTIONAL.
     *
     * @param array|string $audience
     *
     * @return Builder
     */
    public function setAudience($audience): Builder
    {
        return $this->setClaim("aud", $audience);
    }

    /**
     * The "exp" (expiration time) claim identifies the expiration time on
     * or after which the JWT MUST NOT be accepted for processing.  The
     * processing of the "exp" claim requires that the current date/time
     * MUST be before the expiration date/time listed in the "exp" claim.
     * Implementers MAY provide for some small leeway, usually no more than
     * a few minutes, to account for clock skew.  Its value MUST be a number
     * containing a NumericDate value.  Use of this claim is OPTIONAL.
     *
     * @param int $timestamp
     *
     * @return Builder
     */
    public function setExpirationTime(int $timestamp): Builder
    {
        return $this->setClaim("exp", $timestamp);
    }

    /**
     * The "jti" (JWT ID) claim provides a unique identifier for the JWT.
     * The identifier value MUST be assigned in a manner that ensures that
     * there is a negligible probability that the same value will be
     * accidentally assigned to a different data object; if the application
     * uses multiple issuers, collisions MUST be prevented among values
     * produced by different issuers as well.  The "jti" claim can be used
     * to prevent the JWT from being replayed.  The "jti" value is a case-
     * sensitive string.  Use of this claim is OPTIONAL.
     *
     * @param string $id
     *
     * @return Builder
     */
    public function setId(string $id): Builder
    {
        return $this->setClaim("jti", $id);
    }

    /**
     * The "iat" (issued at) claim identifies the time at which the JWT was
     * issued.  This claim can be used to determine the age of the JWT.  Its
     * value MUST be a number containing a NumericDate value.  Use of this
     * claim is OPTIONAL.
     *
     * @param int $timestamp
     *
     * @return Builder
     */
    public function setIssuedAt(int $timestamp): Builder
    {
        return $this->setClaim("iat", $timestamp);
    }

    /**
     * The "iss" (issuer) claim identifies the principal that issued the
     * JWT.  The processing of this claim is generally application specific.
     * The "iss" value is a case-sensitive string containing a StringOrURI
     * value.  Use of this claim is OPTIONAL.
     *
     * @param string $issuer
     *
     * @return Builder
     */
    public function setIssuer(string $issuer): Builder
    {
        return $this->setClaim("iss", $issuer);
    }

    /**
     * The "nbf" (not before) claim identifies the time before which the JWT
     * MUST NOT be accepted for processing.  The processing of the "nbf"
     * claim requires that the current date/time MUST be after or equal to
     * the not-before date/time listed in the "nbf" claim.  Implementers MAY
     * provide for some small leeway, usually no more than a few minutes, to
     * account for clock skew.  Its value MUST be a number containing a
     * NumericDate value.  Use of this claim is OPTIONAL.
     *
     * @param int $timestamp
     *
     * @return Builder
     */
    public function setNotBefore(int $timestamp): Builder
    {
        return $this->setClaim("nbf", $timestamp);
    }

    /**
     * The "sub" (subject) claim identifies the principal that is the
     * subject of the JWT.  The claims in a JWT are normally statements
     * about the subject.  The subject value MUST either be scoped to be
     * locally unique in the context of the issuer or be globally unique.
     * The processing of this claim is generally application specific.  The
     * "sub" value is a case-sensitive string containing a StringOrURI
     * value.  Use of this claim is OPTIONAL.
     *
     * @param string $subject
     *
     * @return Builder
     */
    public function setSubject(string $subject): Builder
    {
        return $this->setClaim("sub", $subject);
    }

    /**
     * @param string $passphrase
     *
     * @return Builder
     * @throws ValidateException
     */
    public function setPassphrase(string $passphrase): Builder
    {
        if (!$this->checkPassphrase($passphrase)) {
            throw new ValidateException(
                'Invalid passphrase (too weak)'
            );
        }

        $this->passphrase = $passphrase;

        return $this;
    }

    /**
     * The passphrase must be more than 16 characters, contain an upper case
     * letter, lower case letter, a number and a special character *&!@%^#$.
     *
     * @param string $passphrase
     *
     * @return bool
     */
    private function checkPassphrase(string $passphrase): bool
    {
        if (
            !preg_match(
                '/^.*(?=.{12,}+)(?=.*[0-9]+)(?=.*[A-Z]+)(?=.*[a-z]+)(?=.*[*&!@%^#\$]+).*$/',
                $passphrase
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Sets a registered claim
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return Builder
     */
    private function setClaim(string $name, $value): Builder
    {
        $this->claims[$name] = $value;

        return $this;
    }
}
