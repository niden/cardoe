<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Security\JWT\Token;

use InvalidArgumentException;
use Phalcon\Helper\Arr;
use Phalcon\Helper\Base64;
use Phalcon\Helper\Json;

use function explode;
use function is_array;

/**
 * Class Parser
 */
class Parser
{
    /**
     * Parse a token and return it
     *
     * @param string $token
     *
     * @return Token
     */
    public function parse(string $token): Token
    {
        [$encodedHeaders, $encodedClaims, $encodedSignature] = $this->parseToken($token);

        $headers   = $this->decodeHeaders($encodedHeaders);
        $claims    = $this->decodeClaims($encodedClaims);
        $signature = $this->decodeSignature($headers, $encodedSignature);

        return new Token($headers, $claims, $signature);
    }

    /**
     * Decode the claims
     *
     * @param string $claims
     *
     * @return Item
     */
    private function decodeClaims(string $claims): Item
    {
        $decoded = Json::decode(Base64::decodeUrl($claims), true);

        if (!is_array($decoded)) {
            throw new InvalidArgumentException(
                "Invalid Claims (not an array)"
            );
        }

        /**
         * Just in case
         */
        if (
            Arr::has($decoded, Enum::AUDIENCE) &&
            !is_array($decoded[Enum::AUDIENCE])
        ) {
            $decoded[Enum::AUDIENCE] = [$decoded[Enum::AUDIENCE]];
        }

        return new Item($decoded, $claims);
    }

    /**
     * Decodes the headers
     *
     * @param string $headers
     *
     * @return Item
     */
    private function decodeHeaders(string $headers): Item
    {
        $decoded = Json::decode(Base64::decodeUrl($headers), true);

        if (!is_array($decoded)) {
            throw new InvalidArgumentException(
                "Invalid Header (not an array)"
            );
        }

        if (!Arr::has($decoded, Enum::TYPE)) {
            throw new InvalidArgumentException(
                "Invalid Header (missing 'typ' element)"
            );
        }

        return new Item($decoded, $headers);
    }

    /**
     * Decodes the signature
     *
     * @param Item   $headers
     * @param string $signature
     *
     * @return Signature
     */
    private function decodeSignature(Item $headers, string $signature): Signature
    {
        $algo = $headers->get(Enum::ALGO, "none");

        if ("none" === $algo) {
            $decoded   = "";
            $signature = "";
        } else {
            $decoded = Base64::decodeUrl($signature);
        }

        return new Signature($decoded, $signature);
    }

    /**
     * Splits the token to its three parts;
     *
     * @param string $token
     *
     * @return array
     */
    private function parseToken(string $token): array
    {
        $parts = explode(".", $token);

        if (count($parts) !== 3) {
            throw new InvalidArgumentException(
                "Invalid JWT string (dots misalignment)"
            );
        }

        return $parts;
    }
}
