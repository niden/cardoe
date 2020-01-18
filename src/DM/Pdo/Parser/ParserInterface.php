<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Pdo\Parser;

/**
 * Interface for query parsing/rebuilding functionality.
 */
interface ParserInterface
{
    /**
     * Rebuilds a query and its parameters to adapt it to PDO's limitations,
     * and returns a list of queries.
     *
     * @param string $string     The query statement string.
     * @param array  $parameters Bind these values into the query.
     *
     * @return array An array where element 0 is the rebuilt statement and
     * element 1 is the rebuilt array of values.
     */
    public function rebuild(string $string, array $parameters = []): array;
}
