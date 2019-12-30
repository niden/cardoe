<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Blueprint;

use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Exception\MutationDoesNotImplementInterface;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Phalcon\Container\Injection\LazyArray;
use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\UnresolvedParameter;
use Phalcon\Test\Fixtures\Container\BlueprintInvoke;
use Phalcon\Test\Fixtures\Container\BlueprintMutation;
use ReflectionClass;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: __invoke()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - __invoke()');

        $parameters = [
            'store' => LazyArray::class,
        ];
        $setters    = [
            'setData' => new LazyArray(),
        ];
        $mutations  = [
            new BlueprintMutation()
        ];

        $blueprint = new Blueprint(BlueprintInvoke::class, $parameters, $setters, $mutations);
        $refection = new ReflectionClass(BlueprintInvoke::class);

        $result = $blueprint($refection);
        $I->assertInstanceOf(BlueprintInvoke::class, $result);
        $I->assertEquals('mutated', $result->store);
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: __invoke() - parameter exception
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintUnderscoreInvokeParameterException(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - __invoke() - parameter exception');

        $I->expectThrowable(
            new MissingParameter(
                'Param missing: invokeClass::$unknown'
            ),
            function () {
                $parameters = [
                    'unknown' => new UnresolvedParameter('unknown'),
                ];
                $blueprint  = new Blueprint('invokeClass', $parameters);
                $refection  = new ReflectionClass(BlueprintInvoke::class);

                $blueprint($refection);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: __invoke() - setter exception
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintUnderscoreInvokeSetterException(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - __invoke() - setter exception');

        $I->expectThrowable(
            new SetterMethodNotFound(
                'Setter method not found: Phalcon\Test\Fixtures\Container\BlueprintInvoke::setUnknown()'
            ),
            function () {
                $setters = [
                    'setUnknown' => 'unknown',
                ];
                $blueprint  = new Blueprint(BlueprintInvoke::class, [], $setters);
                $refection  = new ReflectionClass(BlueprintInvoke::class);

                $blueprint($refection);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: __invoke() - mutation exception
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintUnderscoreInvokeMutationException(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - __invoke() - mutation exception');

        $I->expectThrowable(
            new MutationDoesNotImplementInterface(
                'Expected Mutation interface, got: string'
            ),
            function () {
                $mutations = [
                    'setData' => LazyArray::class,
                ];
                $blueprint  = new Blueprint('invokeClass', [], [], $mutations);
                $refection  = new ReflectionClass(BlueprintInvoke::class);

                $blueprint($refection);
            }
        );
    }
}
