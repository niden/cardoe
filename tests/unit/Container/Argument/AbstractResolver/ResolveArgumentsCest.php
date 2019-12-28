<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Argument\AbstractResolver;

use Codeception\Example;
use Codeception\Stub;
use Exception;
use Phalcon\Container;
use Phalcon\Container\Argument\ClassName;
use Phalcon\Container\Argument\Raw;
use Phalcon\Container\Exception\NotFoundException;
use Phalcon\Test\Fixtures\Container\ArgumentResolver;
use Phalcon\Test\Fixtures\Container\ArgumentResolverResolveArgumentsMethod;
use UnitTester;

class ResolveArgumentsCest
{
    /**
     * Unit Tests Phalcon\Container\Argument\AbstractResolver ::
     * resolveArguments()
     *
     * @param UnitTester $I
     * @param Example    $example
     *
     * @throws       Exception
     * @dataProvider getExamples
     * @since        2019-12-28
     */
    public function containerArgumentAbstractResolverResolveArguments(UnitTester $I, Example $example)
    {
        $I->wantToTest('Container\Argument\AbstractResolver - resolveArguments() - ' . $example['message']);

        $resolver  = $example['resolver'];
        $container = Stub::make(
            Container::class,
            [
                'get' => $example['get'],
                'has' => $example['has'],
            ]
        );

        $resolver->setContainer($container);
        $arguments = $resolver->resolveArguments($example['arguments']);

        $I->assertEquals($example['argument1'], $arguments[0]);
        $I->assertEquals($example['issetArg2'], isset($arguments[1]));
        if (isset($arguments[1])) {
            $I->assertEquals($example['argument2'], $arguments[1]);
        }
    }

    /**
     * Unit Tests Phalcon\Container\Argument\AbstractResolver ::
     * resolveArguments() - exception
     *
     * @param UnitTester $I
     *
     * @throws Exception
     * @since  2019-12-28
     */
    public function containerArgumentAbstractResolverResolveArgumentsException(UnitTester $I)
    {
        $I->wantToTest('Container\Argument\AbstractResolver - resolveArguments() - exception');

        $I->expectThrowable(
            new NotFoundException(
                'Cannot resolve parameter [one] for []',
            ),
            function () {
                $mock = new ArgumentResolverResolveArgumentsMethod();

                $resolver = new ArgumentResolver();
                $resolver->reflectArguments($mock);
            }
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        $resolver = new ArgumentResolver();
        $class    = new ClassName('class1');

        return [
            [
                'message'   => 'string',
                'resolver'  => $resolver,
                'get'       => function ($name) use ($resolver) {
                    if ('one' === $name) {
                        return $resolver;
                    }

                    return null;
                },
                'has'       => function ($name) {
                    return ('one' === $name);
                },
                'arguments' => ['one', 'two'],
                'argument1' => $resolver,
                'issetArg2' => true,
                'argument2' => 'two',
            ],
            [
                'message'   => 'not string',
                'resolver'  => $resolver,
                'get'       => function ($name) use ($resolver) {
                    if ('one' === $name) {
                        return $resolver;
                    }

                    return null;
                },
                'has'       => function ($name) {
                    return ('one' === $name);
                },
                'arguments' => ['one', true],
                'argument1' => $resolver,
                'issetArg2' => false,
                'argument2' => 'not set',
            ],
            [
                'message'   => 'argument raw',
                'resolver'  => $resolver,
                'get'       => function ($name) {
                    if ('one' === $name) {
                        return new Raw('raw1');
                    }

                    return null;
                },
                'has'       => function ($name) {
                    return ('one' === $name);
                },
                'arguments' => [
                    'one',
                    new Raw('raw2'),
                ],
                'argument1' => 'raw1',
                'issetArg2' => true,
                'argument2' => 'raw2',
            ],
            [
                'message'   => 'argument class',
                'resolver'  => $resolver,
                'get'       => function ($name) use ($class) {
                    if ('one' === $name) {
                        return $class;
                    }

                    return null;
                },
                'has'       => function ($name) {
                    return ('one' === $name);
                },
                'arguments' => [
                    'one',
                    new ClassName('class2'),
                ],
                'argument1' => $class,
                'issetArg2' => true,
                'argument2' => 'class2',
            ],
        ];
    }
}
