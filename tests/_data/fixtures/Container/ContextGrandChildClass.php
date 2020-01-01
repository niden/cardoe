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
 * Class ContextGrandChildClass
 *
 * @property string $store
 */
class ContextGrandChildClass
{
    public $store;

    public function __construct(string $store)
    {
        $this->store = $store;
    }
}
