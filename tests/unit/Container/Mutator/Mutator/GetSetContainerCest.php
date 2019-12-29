<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutator;

use Phalcon\Container;
use Phalcon\Container\Mutator\Mutator;
use UnitTester;

class GetSetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator ::
     * getContainer()/setContainer()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorGetSetContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - getContainer()/setContainer()');

        $container = new Container();
        $mutator   = new Mutator("myClass");

        $mutator->setContainer($container);
        $I->assertEquals($container, $mutator->getContainer());
    }
}
