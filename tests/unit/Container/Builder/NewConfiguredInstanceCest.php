<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Builder;

use Phalcon\Container;
use Phalcon\Container\Builder;
use Phalcon\Test\Fixtures\Container\ConfigLibraryFixtureClass;
use Phalcon\Test\Fixtures\Container\ConfigProjectFixtureClass;
use Psr\Container\ContainerInterface;
use UnitTester;

class NewConfiguredInstanceCest
{
    /**
     * Unit Tests Phalcon\Container\Builder :: newConfiguredInstance()
     *
     * @since  2019-12-30
     */
    public function containerBuilderNewConfiguredInstance(UnitTester $I)
    {
        $I->wantToTest('Container\Builder - newConfiguredInstance()');

        $classes = [
            ConfigLibraryFixtureClass::class,
            ConfigProjectFixtureClass::class,
        ];

        $builder = new Builder();
        $container = $builder->newConfiguredInstance($classes);
        $I->assertInstanceOf(ContainerInterface::class, $container);
        $I->assertInstanceOf(Container::class, $container);

        $expect = 'tuvok';
        $actual = $container->get('library');
        $I->assertEquals($expect, $actual->name);

        $expect = 'delta flyer';
        $actual = $container->get('project');
        $I->assertEquals($expect, $actual->ship);
    }

    /**
     * Unit Tests Phalcon\Container\Builder :: newConfiguredInstance() - exception
     *
     * @since  2019-12-30
     */
    public function containerBuilderNewConfiguredInstanceException(UnitTester $I)
    {
        $I->wantToTest('Container\Builder - newConfiguredInstance() - exception');

        $I->expectThrowable(
            new \InvalidArgumentException(
                'Container configs must implement ConfigInterface'
            ),
            function () {
                $builder = new Builder();
                $builder->newConfiguredInstance([]);
            }
        );
    }
}
