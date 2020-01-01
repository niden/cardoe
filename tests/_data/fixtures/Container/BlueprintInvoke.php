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

use Phalcon\Container\Injection\LazyArray;

class BlueprintInvoke
{
    /**
     * @var LazyArray
     */
    public $store;

    public function __construct()
    {

    }

    public function __invoke(object $object): object
    {
        $object->setData('mutated');

        return $object;
    }

    public function setData($data)
    {
        $this->store = $data;
    }
}
