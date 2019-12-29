<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Service\Service;

use Codeception\Example;
use Phalcon\Container\Argument\ClassName;
use Phalcon\Container\Argument\Raw;
use Phalcon\Container\Service\Service;
use Phalcon\Container\Service\ServiceInterface;
use Phalcon\Test\Fixtures\Container\OneClass;
use Phalcon\Test\Fixtures\Container\ThreeClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class ResolveServiceCest
{
    /**
     * Unit Tests Phalcon\Container\Service\Service :: resolveService()
     *
     * @param UnitTester $I
     * @param Example    $example
     *
     * @dataProvider getExample
     * @since        2019-12-28
     */
    public function containerServiceServiceResolveService(UnitTester $I, Example $example)
    {
        $I->wantToTest("Container\Service\Service - resolveService() " . $example["message"]);

        $service = new Service(
            "sampleService",
            $example["definition"]
        );

        if (!empty($example["arguments"])) {
            $actual = $service->addArguments($example["arguments"]);
            $I->assertInstanceOf(Service::class, $actual);
        }

        $actual = $service->resolveService();
        if (is_string($actual)) {
            $I->assertEquals($example["expected"], $actual);
        } else {
            $I->assertInstanceOf($example["expected"], $actual);
        }
    }

    /**
     * Unit Tests Phalcon\Container\Service\Service :: resolveService() - shared
     *
     * @param UnitTester $I
     *
     * @since 2019-12-28
     */
    public function containerServiceServiceResolveServiceShared(UnitTester $I)
    {
        $I->wantToTest("Container\Service\Service - resolveService() - shared");

        $service = new Service(
            "sampleService",
            new ClassName(OneClass::class)
        );

        $actual = $service->setShared(true);
        $I->assertInstanceOf(ServiceInterface::class, $actual);

        $one   = $service->resolveService();
        $two   = $service->resolveService();
        $three = $service->resolveService(true);

        $I->assertEquals(spl_object_hash($one), spl_object_hash($two));
        $I->assertNotEquals(spl_object_hash($two), spl_object_hash($three));
    }

    /**
     * @return array
     */
    private function getExample(): array
    {
        return [
            [
                "message"    => "closure with arguments",
                "definition" => function ($one, $two) {
                    return "one: " . $one . " - two: " . $two;
                },
                "arguments"  => [
                    "one",
                    "two",
                ],
                "expected"   => "one: one - two: two",
            ],
            [
                "message"    => "closure with raw argument",
                "definition" => function () {
                    return new Raw("one - two");
                },
                "arguments"  => [],
                "expected"   => "one - two",
            ],
            [
                "message"    => "callable class",
                "definition" => new ThreeClass(),
                "arguments"  => [
                    new TwoClass(),
                ],
                "expected"   => OneClass::class,
            ],
            [
                "message"    => "callable class with array",
                "definition" => [new ThreeClass(), "__invoke"],
                "arguments"  => [
                    new TwoClass(),
                ],
                "expected"   => OneClass::class,
            ],
        ];
    }
}
