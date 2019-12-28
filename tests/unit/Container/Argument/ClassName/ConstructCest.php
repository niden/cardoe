<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Argument\ClassName;

use Codeception\Example;
use Phalcon\Container\Argument\ClassName;
use stdClass;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Argument\ClassName :: __construct()
     *
     * @param UnitTester $I
     * @param Example    $example
     *
     * @dataProvider getExamples
     * @since        2019-12-28
     */
    public function containerArgumentClassNameConstruct(UnitTester $I, Example $example)
    {
        $I->wantToTest('Container\Argument\ClassName - __construct() . ' . $example[0]);

        $name = new ClassName($example[1]);
        $I->assertEquals($example[1], $name->get());
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                'self class',
                ClassName::class,
            ],
            [
                'standard class',
                stdClass::class,
            ],
            [
                'user defined class',
                "userDefinedClass",
            ],
        ];
    }
}
