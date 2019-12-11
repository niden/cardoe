<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use IntegrationTester;
use function ucfirst;

class QuoteNameCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: quoteName()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionQuoteName(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - quoteName()');

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $driver     = $connection->getDriverName();
        $method     = "getExamples" . ucfirst($driver);
        $examples   = $this->$method();

        foreach ($examples as $example) {
            $I->assertEquals(
                $example[1],
                $connection->quoteName($example[0])
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
                'on`e',
                '`on``e`',
            ],
            [
                'one.`two`',
                '`one`.```two```',
            ],
            [
                'on"e',
                '`on"e`',
            ],
            [
                'one."two"',
                '`one`.`"two"`',
            ],
            [
                'on"e',
                '`on"e`',
            ],
            [
                'one."two"',
                '`one`.`"two"`',
            ],
            [
                'on]e',
                '`on]e`',
            ],
            [
                'on[e',
                '`on[e`',
            ],
            [
                'one.[two]',
                '`one`.`[two]`',
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
                'on`e',
                '"on`e"',
            ],
            [
                'one.`two`',
                '"one"."`two`"',
            ],
            [
                'on"e',
                '"on""e"',
            ],
            [
                'one."two"',
                '"one"."""two"""',
            ],
            [
                'on"e',
                '"on""e"',
            ],
            [
                'one."two"',
                '"one"."""two"""',
            ],
            [
                'on]e',
                '"on]e"',
            ],
            [
                'on[e',
                '"on[e"',
            ],
            [
                'one.[two]',
                '"one"."[two]"',
            ],
        ];
    }
}
