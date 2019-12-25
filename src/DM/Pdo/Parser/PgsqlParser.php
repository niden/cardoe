<?php

/**
 * This file is part of the Phalcon Framework.
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

namespace Phalcon\DM\Pdo\Parser;

/**
 * Parsing/rebuilding functionality for the pgsl driver.
 */
class PgsqlParser extends AbstractParser
{
    /**
     * @var array
     */
    protected $split = [
        // single-quoted string
        "'(?:[^'\\\\]|\\\\'?)*'",
        // double-quoted string
        '"(?:[^"\\\\]|\\\\"?)*"',
        // double-dollar string (empty dollar-tag)
        '\$\$(?:[^\$]?)*\$\$',
        // dollar-tag string -- DOES NOT match tags properly
        '\$[^\$]+\$.*\$[^\$]+\$',
    ];

    /**
     * @var string
     */
    protected $skip = '/^(\'|\"|\$|\:[^a-zA-Z_])/um';
}
