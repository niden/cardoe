<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutator;

use Codeception\Stub;
use Phalcon\Container;
use Phalcon\Container\Mutator\Mutator;
use Phalcon\Test\Fixtures\Container\FourClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class MutateCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: mutate() - properties
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorMutateProperties(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - mutate() - properties');

        $twoClass  = new TwoClass();
        $container = Stub::make(
            Container::class,
            [
                'has' => function ($name) {
                    return (TwoClass::class === $name);
                },
                'get' => function ($name) use ($twoClass) {
                    if (TwoClass::class === $name) {
                        return $twoClass;
                    }

                    return null;
                },
            ]
        );

        $mutator = new Mutator('myClass');
        $mutator
            ->setContainer($container)
            ->setProperty("data", TwoClass::class)
        ;

        $four = new FourClass();
        $mutator->mutate($four);
        $I->assertEquals($twoClass, $four->data);
    }

    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: mutate() - methods
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorMutateMethods(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - mutate() - methods');

        $twoClass  = new TwoClass();
        $container = Stub::make(
            Container::class,
            [
                'has' => function ($name) {
                    return (TwoClass::class === $name);
                },
                'get' => function ($name) use ($twoClass) {
                    if (TwoClass::class === $name) {
                        return $twoClass;
                    }

                    return null;
                },
            ]
        );

        $mutator = new Mutator('myClass');
        $mutator
            ->setContainer($container)
            ->invokeMethod("setData", [TwoClass::class])
        ;

        $four = new FourClass();
        $mutator->mutate($four);
        $I->assertEquals($twoClass, $four->data);
    }

    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: mutate() - callback
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorMutateCallback(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - mutate() - callback');

        $twoClass = new TwoClass();
        $mutator  = new Mutator(
            'myClass',
            function ($object) use ($twoClass) {
                $object->setData($twoClass);
            }
        );

        $four = new FourClass();
        $mutator->mutate($four);
        $I->assertEquals($twoClass, $four->data);
    }
}
