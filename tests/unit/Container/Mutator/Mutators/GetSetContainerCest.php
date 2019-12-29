<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutators;

use Phalcon\Container;
use Phalcon\Container\Mutator\Mutators;
use UnitTester;

class GetSetContainerCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutators ::
     * getContainer()/setContainer()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorsGetSetContainer(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutators - getContainer()/setContainer()');

        $container = new Container();
        $mutators  = new Mutators();

        $mutators->setContainer($container);
        $I->assertEquals($container, $mutators->getContainer());
    }
}
