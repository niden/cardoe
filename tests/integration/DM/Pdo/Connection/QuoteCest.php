<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use Phalcon\DM\Pdo\Connection;
use IntegrationTester;

use function ucfirst;

class QuoteCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: quote()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionQuote(IntegrationTester $I)
    {
        /** @var Connection $connection */
        $connection = $I->getConnection();
        $driver     = $connection->getDriverName();
        $method     = "getExamples" . ucfirst($driver);
        $examples   = $this->$method();

        foreach ($examples as $example) {
            $I->wantToTest('DM\Pdo\Connection - quote() - ' . $example[0]);
            $I->assertEquals(
                $example[2],
                $connection->quote($example[1])
            );
        }
    }

    /**
     * @return array
     */
    private function getExamplesMysql(): array
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
                    4,
                    5,
                ],
                "'\\\"one\\\"', 'two', '\'three\'', '4', '5'",
            ],
            [
                'null',
                null,
                "''"
            ],
        ];
    }

    /**
     * @return array
     */
    private function getExamplesSqlite(): array
    {
        return [
            [
                'double',
                '"one" two \'three\'',
                "'\"one\" two ''three'''",
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
                "'\"one\"', 'two', '''three'''",
            ],
            [
                'null',
                null,
                "''"
            ],
        ];
    }
}
