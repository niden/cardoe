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

/**
 * Class Token
 *
 * @property string $passphrase
 * @property string $token
 *
 * @link https://tools.ietf.org/html/rfc7519
 */
class Token
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $passphrase;

    /**
     * Token constructor.
     *
     * @param string $token
     * @param string $passphrase
     */
    public function __construct(string $token, string $passphrase)
    {
        $this->passphrase = $passphrase;
        $this->token      = $token;
    }

    /**
     * @return string
     */
    public function getPassphrase(): string
    {
        return $this->passphrase;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
