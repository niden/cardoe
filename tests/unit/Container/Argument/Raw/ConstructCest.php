<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Argument\Raw;

use Codeception\Example;
use Phalcon\Collection;
use Phalcon\Container\Argument\Raw;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Argument\Raw :: __construct()
     *
     * @param UnitTester $I
     * @param Example    $example
     *
     * @dataProvider getExamples
     * @since        2019-12-28
     */
    public function containerArgumentRawConstruct(UnitTester $I, Example $example)
    {
        $I->wantToTest('Container\Argument\Raw - __construct() . ' . $example[0]);

        $name = new Raw($example[1]);
        $I->assertEquals($example[1], $name->get());
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                'anonymous',
                function () {
                },
            ],
            [
                'bool',
                true,
            ],
            [
                'class',
                new Collection(),
            ],
            [
                'float',
                123.45,
            ],
            [
                'int',
                1234,
            ],
            [
                'null',
                null,
            ],
            [
                'string',
                'some string',
            ],
        ];
    }
}
