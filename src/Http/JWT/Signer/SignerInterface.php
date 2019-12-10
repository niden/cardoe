<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\JWT\Signer;

interface SignerInterface
{
    /**
     * Return the algorithm name
     *
     * @return string
     */
    public function getAlgo(): string;

    /**
     * Return the hash string
     *
     * @param string $payload
     * @param string $passphrase
     *
     * @return string
     */
    public function getHash(string $payload, string $passphrase): string;

    /**
     * @param string $data
     * @param string $passphrase
     *
     * @return mixed
     */
    public function sign(string $data, string $passphrase);

    /**
     * @param string $hash
     * @param string $payload
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $hash, string $payload, string $passphrase): bool;
}
