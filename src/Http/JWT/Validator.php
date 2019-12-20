<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT;

use Phalcon\Collection;
use Phalcon\Http\JWT\Signer\SignerInterface;
use Phalcon\Http\JWT\Exceptions\ValidatorException;
use Phalcon\Http\JWT\Token\Enum;

class Validator
{
    /**
     * @param mixed $audience
     *
     * @return bool
     */
    public function audience($audience): bool
    {
        return is_string($audience) || is_array($audience);
    }

    /**
     * @param int $timestamp
     *
     * @return bool
     */
    public function expiration(int $timestamp): bool
    {
        return $timestamp > time();
    }

    /**
     * @param int $timestamp
     *
     * @return bool
     */
    public function notBefore(int $timestamp): bool
    {
        return $timestamp < time();
    }

    /**
     * @param string $passphrase
     *
     * @return bool
     */
    public function passphrase(string $passphrase): bool
    {
        if (
            !preg_match(
                "/^.*(?=.{12,}+)(?=.*[0-9]+)(?=.*[A-Z]+)(?=.*[a-z]+)(?=.*[*&!@%^#\$]+).*$/",
                $passphrase
            )
        ) {
            return false;
        }

        return true;
    }
}
