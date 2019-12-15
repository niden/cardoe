<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT\Encoder;

use Phalcon\Http\JWT\Encoder\EncoderInterface;
use Phalcon\Http\JWT\Exceptions\UnsupportedAlgorithmException;

use function hash_equals;
use function hash_hmac;

/**
 * Class AbstractHmac
 *
 * @property string $algo
 */
class Hmac implements EncoderInterface
{
    /**
     * @var string
     */
    protected $algo = "sha512";

    /**
     * Hmac constructor.
     *
     * @param string $algo
     *
     * @throws UnsupportedAlgorithmException
     */
    public function __construct(string $algo = "sha512")
    {
        if (
            "sha512" !== $algo &&
            "sha384" !== $algo &&
            "sha256" !== $algo
        ) {
            throw new UnsupportedAlgorithmException(
                "Unsupported HMAC algorithm"
            );
        };

        $this->algo = $algo;
    }

    /**
     * Return the algorithm used
     *
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algo;
    }

    /**
     * Sign a payload using the passphrase
     *
     * @param string $payload
     * @param string $passphrase
     *
     * @return string
     */
    public function sign(string $payload, string $passphrase): string
    {
        return $this->getHash($payload, $passphrase);
    }

    /**
     * Verify a passed source with a payload and passphrase
     *
     * @param string $source
     * @param string $payload
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $source, string $payload, string $passphrase): bool
    {
        return hash_equals($source, $this->getHash($payload, $passphrase));
    }

    /**
     * Calculates a hash from the passed parameters
     *
     * @param string $payload
     * @param string $passphrase
     *
     * @return string
     */
    private function getHash(string $payload, string $passphrase): string
    {
        return hash_hmac($this->getAlgorithm(), $payload, $passphrase, true);
    }
}
