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

use Phalcon\Container\Injection\MutationInterface;

class MutationFixtureClass implements MutationInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Invokes the Mutation to return an object.
     *
     * @param object|InterfaceFixtureClass $object
     *
     * @return object
     */
    public function __invoke(object $object): object
    {
        $object->setShip($this->value);

        return $object;
    }
}