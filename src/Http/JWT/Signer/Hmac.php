<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT\Signer\Hmac;

use Phalcon\Http\JWT\Exceptions\UnsupportedAlgorithmException;
use Phalcon\Http\JWT\Signer\SignerInterface;

use function hash_equals;
use function hash_hmac;

/**
 * Class AbstractHmac
 *
 * @property string $algo
 */
class Hmac implements SignerInterface
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
     * Returns the algorithm name
     *
     * @return string
     */
    public function getAlgo(): string
    {
        return $this->algo;
    }

    /**
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
     * @param string $hash
     * @param string $payload
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $hash, string $payload, string $passphrase): bool
    {
        return hash_equals($hash, $this->getHash($payload, $passphrase));
    }

    /**
     * @param string $payload
     * @param string $passphrase
     *
     * @return string
     */
    public function getHash(string $payload, string $passphrase): string
    {
        return hash_hmac(
            $this->getAlgo(),
            $payload,
            $passphrase,
            true
        );
    }
}
