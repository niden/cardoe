<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Security;

use Cardoe\Helper\Arr;
use InvalidArgumentException;
use function password_get_info;
use function password_hash;
use function password_verify;

use function strlen;
use function trim;
use const PASSWORD_ARGON2I;
use const PASSWORD_BCRYPT;

class Password
{
    public const ALGO_DEFAULT       = 1;
    public const ALGO_BCRYPT        = 1;
    public const ALGO_ARGON2I       = 2;
    public const ALGO_ARGON2ID      = 3;
    public const ARGON2_MEMORY_COST = 65536;
    public const ARGON2_TIME_COST   = 4;
    public const ARGON2_THREADS     = 1;

    /**
     * @var int
     */
    private $workFactor = 10;

    /**
     * @param string $password
     * @param int    $algorithm
     * @param array  $options
     *
     * @return false|string|null
     */
    public function hash(
        string $password,
        int $algorithm = self::ALGO_DEFAULT,
        array $options = []
    ): string {

        $salt = Arr::get($options, 'salt', null);

        /**
         * Check if the salt was defined and if it is good enough
         */
        if (!empty($salt) && strlen(trim($salt)) < 32) {
            throw new InvalidArgumentException(
                "The 'salt' cannot be less than 32 characters"
            );
        }

        return password_hash($password, $algorithm, $options);
    }

    /**
     * @param string      $password
     * @param int         $cost
     * @param string|null $salt
     *
     * @return false|string|null
     */
    public function hashBcrypt(
        string $password,
        int $cost = 10,
        string $salt = null
    ) {
        $options = [
            'cost' => $cost,
        ];

        /**
         * Check if the salt was defined and if it is good enough
         */
        if (!empty($salt)) {
            if (strlen(trim($salt)) < 32) {
                throw new InvalidArgumentException(
                    "The 'salt' cannot be less than 32 characters"
                );
            }

            $options['salt'] = $salt;
        }

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function hashArgon2i(
        string $password,
        int $memoryCost = self::ARGON2_MEMORY_COST,
        int $timeCost = self::ARGON2_TIME_COST,
        int $numThreads = self::ARGON2_THREADS
    ): string {
        return $this->hashArgon(
            $password,
            PASSWORD_ARGON2I,
            $memoryCost,
            $timeCost,
            $numThreads
        );
    }

    public function hashArgon2id(
        string $password,
        int $memoryCost = self::ARGON2_MEMORY_COST,
        int $timeCost = self::ARGON2_TIME_COST,
        int $numThreads = self::ARGON2_THREADS
    ): string {
        return $this->hashArgon(
            $password,
            PASSWORD_ARGON2ID,
            $memoryCost,
            $timeCost,
            $numThreads
        );
    }

    /**
     * @param string $hash
     *
     * @return array
     */
    public function info(
        string $hash
    ): array {
        return password_get_info($hash);
    }

    /**
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * @param string $password
     * @param int    $algorithm
     * @param int    $memoryCost
     * @param int    $timeCost
     * @param int    $numThreads
     *
     * @return string
     */
    private function hashArgon(
        string $password,
        int $algorithm,
        int $memoryCost,
        int $timeCost,
        int $numThreads
    ): string {
        return password_hash(
            $password,
            $algorithm,
            [
                'memory_cost' => $memoryCost,
                'time_cost'   => $timeCost,
                'threads'     => $numThreads,
            ]
        );
    }
}
