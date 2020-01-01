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

class InterfaceFixtureClass implements InterfaceFixture
{
    protected $ship;

    public function getShip()
    {
        return $this->ship;
    }

    public function setShip($ship)
    {
        $this->ship = $ship;

        return $this;
    }
}
