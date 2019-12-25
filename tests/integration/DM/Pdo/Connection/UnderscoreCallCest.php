<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use BadMethodCallException;
use Phalcon\DM\Pdo\Connection;
use Phalcon\Test\Fixtures\DM\Pdo\ConnectionFixture;
use IntegrationTester;

class UnderscoreCallCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: __call()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionUnderscoreCall(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __call()');

        /** @var Connection $connection */
        $connection = new ConnectionFixture(
            $I->getDatabaseDsn(),
            $I->getDatabaseUsername(),
            $I->getDatabasePassword()
        );

        $actual = $connection->callMe('blondie');
        $I->assertEquals('blondie', $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: __call() - exception
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionUnderscoreCallException(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - __call() - exception');

        $I->expectThrowable(
            new BadMethodCallException(
                "Class 'Phalcon\DM\Pdo\Connection' does not have a method 'unknown'"
            ),
            function () use ($I) {
                /** @var Connection $connection */
                $connection = $I->getConnection();

                $connection->unknown();
            }
        );
    }
}
