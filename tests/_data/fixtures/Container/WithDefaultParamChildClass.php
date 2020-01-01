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

/**
 * Class WithDefaultParamChildClass
 */
class WithDefaultParamChildClass extends WithDefaultParamParentClass
{
    public $first;
    public $second;

    public function __construct($first = 1, $second = 3)
    {
        parent::__construct($first, $second);
    }
}
