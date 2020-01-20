<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Query\Select;

use BadMethodCallException;
use IntegrationTester;
use PDOStatement;
use Phalcon\DM\Query\QueryFactory;
use Phalcon\Test\Fixtures\Migrations\Invoices;

class UnderscoreCallCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: __call()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectUnderscoreCall(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - __call()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);
        (new Invoices($connection));

        $select->from('co_invoices');
        $expected = [];
        $actual   = $select->fetchAll();
        $I->assertEquals($expected, $actual);
        $I->assertInstanceOf(PDOStatement::class, $select->perform());
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: __call() - exception
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectUnderscoreCallException(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - __call()');

        $I->expectThrowable(
            new BadMethodCallException(
                'Unknown method: [unknown]'
            ),
            function () use ($I) {
                $connection = $I->getConnection();
                $factory    = new QueryFactory();
                $select     = $factory->newSelect($connection);

                $select->from('co_invoices');
                $select->unknown();
            }
        );
    }
}
