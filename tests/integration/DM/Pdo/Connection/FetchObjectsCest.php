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

class FetchObjectsCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchObjects()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchObjects(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchObjects()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchObjects(
            'SELECT * from co_invoices'
        );
        $I->assertCount(4, $all);

        $I->assertInstanceOf(stdClass::class, $all[0]);
        $I->assertInstanceOf(stdClass::class, $all[1]);
        $I->assertInstanceOf(stdClass::class, $all[2]);
        $I->assertInstanceOf(stdClass::class, $all[3]);

        $I->assertEquals(1, $all[0]->inv_id);
        $I->assertEquals(2, $all[1]->inv_id);
        $I->assertEquals(3, $all[2]->inv_id);
        $I->assertEquals(4, $all[3]->inv_id);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchObjects() - ctor
     *
     * @since  2019-11-16
     */
    public function connectionFetchObjectsCtor(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchObjects() - ctor');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(2);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(3);
        $I->assertEquals(1, $result);
        $result = $this->newInvoice(4);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchObjects(
            'SELECT * from co_invoices',
            [],
            Resultset::class,
            [
                'darth'
            ]
        );
        $I->assertCount(4, $all);

        $I->assertInstanceOf(Resultset::class, $all[0]);
        $I->assertInstanceOf(Resultset::class, $all[1]);
        $I->assertInstanceOf(Resultset::class, $all[2]);
        $I->assertInstanceOf(Resultset::class, $all[3]);

        $I->assertEquals(1, $all[0]->inv_id);
        $I->assertEquals(2, $all[1]->inv_id);
        $I->assertEquals(3, $all[2]->inv_id);
        $I->assertEquals(4, $all[3]->inv_id);

        $I->assertEquals('darth', $all[0]->calculated);
        $I->assertEquals('darth', $all[1]->calculated);
        $I->assertEquals('darth', $all[2]->calculated);
        $I->assertEquals('darth', $all[3]->calculated);
    }
}
