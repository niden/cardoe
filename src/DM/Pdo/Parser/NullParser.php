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
 * A parser/rebuilder that does nothing at all; use this when your placeholders
 * and bound-values are already perfectly matched.
 */
class NullParser implements ParserInterface
{
    /**
     * Leaves the query and parameters alone.
     *
     * @param string $statement
     * @param array  $values
     *
     * @return array
     */
    public function rebuild(string $statement, array $values = []): array
    {
        return [$statement, $values];
    }
}
