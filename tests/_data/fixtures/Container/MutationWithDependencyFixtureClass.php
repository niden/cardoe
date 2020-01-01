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

use Phalcon\Container;
use Phalcon\Container\Injection\MutationInterface;

class MutationWithDependencyFixtureClass implements MutationInterface
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
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
        $object->setShip($this->container->get('service'));

        return $object;
    }
}
