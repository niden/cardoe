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

namespace Phalcon\Test\Fixtures\Container;

use InvalidArgumentException;

/**
 * Class NullParentConstructClass
 */
class NullParentConstructClass
{
    public function __construct($store = 'seven')
    {
        if (!is_null($store)) {
            throw new InvalidArgumentException('Must receive null');
        }
    }
}
