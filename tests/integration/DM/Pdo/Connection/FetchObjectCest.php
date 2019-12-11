<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\Test\Fixtures\Resultset;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;
use stdClass;

class FetchObjectCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchObject()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchObject(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchObject()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchObject(
            'select inv_id, inv_total from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );

        $I->assertInstanceOf(stdClass::class, $all);
        $I->assertEquals(1, $all->inv_id);
        $I->assertEquals(101, $all->inv_total);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchObject() - ctor
     *
     * @since  2019-11-16
     */
    public function connectionFetchObjectCtor(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchObject() - ctor');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchObject(
            'select inv_id, inv_total from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ],
            Resultset::class,
            [
                'vader'
            ]
        );

        $I->assertInstanceOf(Resultset::class, $all);
        $I->assertEquals('vader', $all->calculated);
        $I->assertEquals(1, $all->inv_id);
        $I->assertEquals(101, $all->inv_total);
    }
}
