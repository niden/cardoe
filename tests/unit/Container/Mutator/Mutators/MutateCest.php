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
use Phalcon\Test\Fixtures\Container\FourClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class MutateCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutators :: mutate()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorsMutate(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutators - mutate()');

        $container = new Container();
        $mutators  = new Mutators();
        $mutators->setContainer($container);

        $four = new FourClass();
        $mutators
            ->add(FourClass::class)
            ->invokeMethod('setData', [TwoClass::class])
        ;
        $mutators->add("unknownClass");

        $result = $mutators->mutate($four);
    }
}
