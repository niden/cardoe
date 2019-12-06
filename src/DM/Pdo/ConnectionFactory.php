<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo;

/**
 * PDO connection factory
 */
class ConnectionFactory
{
    /**
     * New instance generator
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array  $options
     *
     * @return Connection
     */
    public function newInstance(
        string $dsn,
        string $username = '',
        string $password = '',
        array $options = []
    ): Connection {
        return new Connection($dsn, $username, $password, $options);
    }
}
