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

class JoinCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: join() - left
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectJoinLeft(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - join() - left');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->join($select::JOIN_LEFT, 'co_customers', 'inv_cst_id = cst_id')
        ;

        $expected = "SELECT * FROM co_invoices "
            . "LEFT JOIN co_customers ON inv_cst_id = cst_id"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: join() - on right
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectJoinRight(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - join() - on right');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->join($select::JOIN_RIGHT, 'co_customers', 'inv_cst_id = cst_id')
        ;

        $expected = "SELECT * FROM co_invoices "
            . "RIGHT JOIN co_customers ON inv_cst_id = cst_id"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

     /**
     * Integration Tests Phalcon\DM\Query\Select :: join() - inner
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectJoinInner(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - join() - inner');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->join($select::JOIN_INNER, 'co_customers', 'inv_cst_id = cst_id')
        ;


        $expected = "SELECT * FROM co_invoices "
            . "INNER JOIN co_customers ON inv_cst_id = cst_id"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: join()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectJoinNatural(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - join() - natural');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->join($select::JOIN_NATURAL, 'co_customers', 'inv_cst_id = cst_id')
        ;

        $expected = "SELECT * FROM co_invoices "
            . "NATURAL JOIN co_customers ON inv_cst_id = cst_id"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Integration Tests Phalcon\DM\Query\Select :: join() - with bind
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectJoinWithBind(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - join() - with bind');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $select
            ->from('co_invoices')
            ->join(
                $select::JOIN_LEFT,
                'co_customers',
                'inv_cst_id = cst_id AND cst_status_flag = ',
                1
            )
            ->catJoin(' AND cst_name LIKE ', '%john%')
        ;

        $expected = "SELECT * FROM co_invoices "
            . "LEFT JOIN co_customers ON inv_cst_id = cst_id "
            . "AND cst_status_flag = :__1__ AND cst_name LIKE :__2__"
        ;
        $actual = $select->getStatement();
        $I->assertEquals($expected, $actual);

        $expected = [
            '__1__' => [1, PDO::PARAM_INT],
            '__2__' => ['%john%', PDO::PARAM_STR],
        ];
        $actual = $select->getBindValues();
        $I->assertEquals($expected, $actual);
    }
}
