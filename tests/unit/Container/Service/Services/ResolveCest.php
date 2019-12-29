<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Services;

use Phalcon\Container;
use Phalcon\Container\Service\Services;
use Phalcon\Test\Fixtures\Container\OneClass;
use UnitTester;

class ResolveCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Services :: resolve()
     *
     * @since  2019-12-28
     */
    public function containerServiceServicesResolve(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Services - resolve()');

        $container = new Container();
        $services  = new Services();
        $services->setContainer($container);

        $services->add('one', OneClass::class, true);
        $services->add('two', OneClass::class);

        $oneOne   = $services->resolve('one');
        $oneTwo   = $services->resolve('one');
        $oneThree = $services->resolve('one', true);
        $twoOne   = $services->resolve('two');
        $twoTwo   = $services->resolve('two');

        $I->assertEquals(spl_object_hash($oneOne), spl_object_hash($oneTwo));
        $I->assertNotEquals(spl_object_hash($oneTwo), spl_object_hash($oneThree));
        $I->assertNotEquals(spl_object_hash($twoOne), spl_object_hash($twoTwo));
    }
}
