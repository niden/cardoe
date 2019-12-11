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

namespace Cardoe\DM\Pdo\Parser;

/**
 * A parser/rebuilder that does nothing at all; use this when your placeholders
 * and bound-values are already perfectly matched.
 */
class NullParser implements ParserInterface
{
    /**
     * Leaves the query and parameters alone.
     *
     * @param string $statement The query statement string.
     * @param array  $values    Bind these values into the query.
     *
     * @return array
     */
    public function rebuild(string $statement, array $values = []): array
    {
        return [$statement, $values];
    }
}
