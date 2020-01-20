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
use PDO;
use Phalcon\DM\Query\QueryFactory;

class HavingCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: having()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectHaving(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - having()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->having('inv_total = :total')
            ->bindValue('total', 100)
        ;


        $expected = "SELECT * FROM co_invoices HAVING inv_total = :total";
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            'total' => [100, PDO::PARAM_INT]
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: having() - complex
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectHavingComplex(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - having() - complex');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->having('inv_total = :total')
            ->andHaving('inv_cst_id = 1')
            ->orHaving('(inv_status_flag = 0 ')
            ->catHaving('OR inv_status_flag = 1)')
            ->bindValue('total', 100)
        ;


        $expected = "SELECT * FROM co_invoices "
            . "HAVING inv_total = :total AND "
            . "inv_cst_id = 1 OR "
            . "(inv_status_flag = 0 OR inv_status_flag = 1)"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            'total' => [100, PDO::PARAM_INT]
        ];
        $actual   = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }
}
