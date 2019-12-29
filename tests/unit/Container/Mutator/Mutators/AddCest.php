<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutators;

use Phalcon\Container\Mutator\MutatorInterface;
use Phalcon\Container\Mutator\Mutators;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class AddCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutators :: add()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorsAdd(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutators - add()');

        $mutators = new Mutators();
        $mutator  = $mutators->add(TwoClass::class);
        $I->assertInstanceOf(MutatorInterface::class, $mutator);
        $I->assertEquals(TwoClass::class, $mutator->getClassName());
    }
}
