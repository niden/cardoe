<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Service;

use Phalcon\Container\Argument\ClassName;
use Phalcon\Container\Argument\Raw;
use Phalcon\Container\Service\Service;
use Phalcon\Test\Fixtures\Container\OneClass;
use UnitTester;

class GetSetCompiledCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service ::
     * getCompiled()/setCompiled()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceGetCompiled(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - getCompiled()/setCompiled()');

        $argument = new ClassName(OneClass::class);
        $service  = new Service('helloService');

        $I->assertEquals("helloService", $service->getCompiled());

        $service->setCompiled($argument);
        $I->assertEquals($argument, $service->getCompiled());
    }

    /**
     * Unit Tests Phalcon\Container\Service\Service ::
     * getCompiled()/setCompiled()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceGetCompiledConstructor(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - getCompiled()/setCompiled() - constructor');

        $argument = new ClassName(OneClass::class);
        $service  = new Service('helloService', $argument);

        $I->assertEquals($argument, $service->getCompiled());
    }
}
