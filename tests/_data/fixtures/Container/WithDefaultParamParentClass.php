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
 * Class WithDefaultParamClass
 */
class WithDefaultParamParentClass
{
    public $first;
    public $second;

    public function __construct($first = 1, $second = 2)
    {
        $this->first = $first;
        $this->second = $second;
    }
}
