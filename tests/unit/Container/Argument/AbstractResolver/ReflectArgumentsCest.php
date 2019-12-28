<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Argument\AbstractResolver;

use Codeception\Stub;
use Phalcon\Container;
use Phalcon\Test\Fixtures\Container\ArgumentResolver;
use Phalcon\Test\Fixtures\Container\ArgumentResolverReflectArgumentsMethod;
use UnitTester;

class ReflectArgumentsCest
{
    /**
     * Unit Tests Phalcon\Container\Argument\AbstractResolver ::
     * reflectArguments()
     *
     * @since  2019-12-28
     */
    public function containerArgumentAbstractResolverReflectArguments(UnitTester $I)
    {
        $I->wantToTest('Container\Argument\AbstractResolver - reflectArguments()');

        $method   = new ArgumentResolverReflectArgumentsMethod();
        $resolver = new ArgumentResolver();
        $container = Stub::make(
            Container::class,
            [
                'get' => function () {
                    return false;
                }
            ]
        );

        $resolver->setContainer($container);
        $data = $resolver->reflectArguments(
            $method,
            [
                'parameterThree' => 'parameterFour',
            ]
        );

        $I->assertEquals(
            [
                'ClassOne',
                'twoDefault',
                'parameterFour',
            ],
            $data
        );
    }
}
