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

class QuoteNameCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: quoteName()
     *
     * @dataProvider getExamples
     * @since  2019-12-11
     */
    public function dMPdoConnectionQuoteName(IntegrationTester $I, Example $example)
    {
        $I->wantToTest('DM\Pdo\Connection - quoteName()');

        $I->assertEquals(
            $example[0],
            $this->connection->quoteName($example[1])
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                '`on``e`',
                'on`e',
            ],
            [
                '`one`.```two```',
                'one.`two`',
            ],
            [
                '`on"e`',
                'on"e',
            ],
            [
                '`one`.`"two"`',
                'one."two"',
            ],
            [
                '`on"e`',
                'on"e',
            ],
            [
                '`one`.`"two"`',
                'one."two"',
            ],
            [
                '`on]e`',
                'on]e',
            ],
            [
                '`on[e`',
                'on[e',
            ],
            [
                '`one`.`[two]`',
                'one.[two]',
            ],
        ];
    }
}
