<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container\Builder;
use Phalcon\Container\Injection\LazyArray;
use Phalcon\Container\Injection\LazyNew;
use Phalcon\Test\Fixtures\Container\OtherFixtureClass;
use UnitTester;

class LazyArrayCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyArray()
     *
     * @since  2020-01-01
     */
    public function containerLazyArray(UnitTester $I)
    {
        $I->wantToTest('Container - lazyArray()');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazyArray = $container->lazyArray(
            [
                $container->lazyNew(OtherFixtureClass::class),
            ]
        );

        $I->assertInstanceOf(LazyArray::class, $lazyArray);
        $actual = $lazyArray();

        $I->assertIsArray($actual);
        $I->assertArrayHasKey(0, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual[0]);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyArray() - append
     *
     * @since  2020-01-01
     */
    public function containerLazyArrayAppend(UnitTester $I)
    {
        $I->wantToTest('Container - lazyArray() - append');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazyArray = $container->lazyArray([]);
        $lazyArray->append(
            $container->lazyNew(OtherFixtureClass::class)
        );

        $I->assertInstanceOf(LazyArray::class, $lazyArray);
        $actual = $lazyArray();

        $I->assertIsArray($actual);
        $I->assertArrayHasKey(0, $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual[0]);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyArray() - append with key
     *
     * @since  2020-01-01
     */
    public function containerLazyArrayAppendWithKey(UnitTester $I)
    {
        $I->wantToTest('Container - lazyArray() - append with key');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazyArray          = $container->lazyArray([]);
        $lazyArray['other'] = $container->lazyNew(OtherFixtureClass::class);

        $I->assertInstanceOf(LazyArray::class, $lazyArray);
        $actual = $lazyArray();

        $I->assertIsArray($actual);
        $I->assertArrayHasKey('other', $actual);
        $I->assertInstanceOf(OtherFixtureClass::class, $actual['other']);
    }

    /**
     * Unit Tests Phalcon\Container :: lazyArray() - arrayCopy
     *
     * @since  2020-01-01
     */
    public function containerLazyArrayArrayCopy(UnitTester $I)
    {
        $I->wantToTest('Container - lazyArray() - arrayCopy');

        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazyArray          = $container->lazyArray([]);
        $lazyArray['other'] = $container->lazyNew(OtherFixtureClass::class);

        $I->assertInstanceOf(LazyArray::class, $lazyArray);

        $actual = $lazyArray->getArrayCopy();

        $I->assertIsArray($actual);
        $I->assertArrayHasKey('other', $actual);
        $I->assertInstanceOf(LazyNew::class, $actual['other']);
    }
}
