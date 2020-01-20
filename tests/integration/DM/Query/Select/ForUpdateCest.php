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

class ForUpdateCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: forUpdate()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectForUpdate(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - forUpdate()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->forUpdate()
        ;

        $expected = "SELECT * FROM co_invoices FOR UPDATE";
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: forUpdate() - unset
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectForUpdateUnset(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - forUpdate() - unset');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->forUpdate()
            ->forUpdate(false)
        ;

        $expected = "SELECT * FROM co_invoices";
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }
}
