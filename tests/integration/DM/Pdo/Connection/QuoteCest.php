<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use Codeception\Example;
use IntegrationTester;

class QuoteCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: quote()
     *
     * @dataProvider getExamples
     * @since  2019-12-11
     */
    public function dMPdoConnectionQuote(IntegrationTester $I, Example $example)
    {
        $I->wantToTest('DM\Pdo\Connection - quote() - ' . $example[0]);

        $actual = $this->connection->quote($example[1]);
        $I->assertEquals($example[2], $actual);
    }

    private function getExamples(): array
    {
        return [
            [
                'double',
                '"one" two \'three\'',
                "'\\\"one\\\" two \'three\''",
            ],
            [
                'integer',
                12345,
                "'12345'",
            ],
            [
                'float',
                123.456,
                "'123.456'"
            ],
            [
                'array',
                [
                    '"one"',
                    'two',
                    "'three'",
                ],
                "'\\\"one\\\"', 'two', '\'three\''",
            ],
            [
                'null',
                null,
                "''"
            ],
        ];
    }
}
