<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Service;

use Codeception\Stub;
use Phalcon\Container;
use Phalcon\Container\Service\Service;
use Phalcon\Test\Fixtures\Container\OneClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class AddMethodsCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: addMethods()
     *
     * @since  2019-12-28
     */
    public function containerServiceServiceAddMethods(UnitTester $I)
    {
        $I->wantToTest('Container\Service\Service - addMethods()');

        $two = new TwoClass();
        $container = Stub::make(
            Container::class,
            [
                "has" => function ($name) {
                    return ($name === TwoClass::class);
                },
                "get" => function ($name) use ($two) {
                    if ($name === TwoClass::class) {
                        return $two;
                    }

                    return null;
                }
            ]
        );

        $service = new Service("sampleService", OneClass::class);
        $service->setContainer($container);
        $service->addMethods(
            [
                "setClass" => [
                    TwoClass::class
                ],
                "setOptional" => [
                    "preset optional"
                ],
            ]
        );

        $actual = $service->resolveService();
        $I->assertInstanceOf(OneClass::class, $actual);
        $I->assertInstanceOf(TwoClass::class, $actual->class);
        $I->assertEquals("preset optional", $actual->optional);
    }
}
