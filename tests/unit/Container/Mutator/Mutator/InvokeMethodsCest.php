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
use ReflectionClass;
use UnitTester;

class InvokeMethodsCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: invokeMethods()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorInvokeMethods(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - invokeMethods()');

        $container = new Container();
        $mutator   = new Mutator('CrewClass');
        $mutator->setContainer($container);

        $source = [
            'setName'     => ['Seven'],
            'setLastName' => ['of Nine'],
        ];
        $mutator->invokeMethods($source);

        $reflection = new ReflectionClass($mutator);
        $methods    = $reflection->getProperty('methods');
        $methods->setAccessible(true);

        $I->assertEquals($source, $methods->getValue($mutator));
    }
}
