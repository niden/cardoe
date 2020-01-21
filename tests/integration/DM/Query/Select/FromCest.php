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

use IntegrationTester;
use Phalcon\DM\Query\QueryFactory;

class FromCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: from()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectFrom(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - from()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->from('co_customers')
        ;

        $expected = "SELECT * FROM co_invoices, co_customers";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: from() - empty
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectFromEmpty(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - from() - empty');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);


        $expected = "SELECT *";
        $actual   = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}
