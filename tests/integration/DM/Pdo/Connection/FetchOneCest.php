<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use Codeception\Example;
use IntegrationTester;
use PDO;
use Phalcon\DM\Pdo\Connection;
use Phalcon\DM\Pdo\Exception\CannotBindValue;
use Phalcon\Test\Fixtures\Migrations\Invoices;
use stdClass;

class FetchOneCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: fetchOne()
     *
     * @since  2020-01-25
     */
    public function dMPdoConnectionFetchOne(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne()');

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $invoice    = new Invoices($connection);

        $result = $invoice->insert($connection, 1);
        $I->assertEquals(1, $result);

        $all = $connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 1,
            ]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
        $I->assertArrayHasKey('inv_id', $all);
        $I->assertArrayHasKey('inv_cst_id', $all);
        $I->assertArrayHasKey('inv_status_flag', $all);
        $I->assertArrayHasKey('inv_title', $all);
        $I->assertArrayHasKey('inv_total', $all);
        $I->assertArrayHasKey('inv_created_at', $all);
    }

    /**
     * Tests Phalcon\DM\Pdo\Connection :: fetchOne() - no result
     *
     * @since  2019-11-16
     */
    public function dMPdoConnectionFetchOneNoResult(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - no result');

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $invoice    = new Invoices($connection);

        $result = $invoice->insert($connection, 1);
        $I->assertEquals(1, $result);

        $all = $connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 7,
            ]
        );

        $I->assertIsArray($all);
        $I->assertIsEmpty($all);
    }

    /**
     * Tests Phalcon\DM\Pdo\Connection :: fetchOne() - bind types
     *
     * @dataProvider getBindTypes
     * @since        2019-11-16
     */
    public function dMPdoConnectionFetchOneBindTypes(IntegrationTester $I, Example $example)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - bind types - ' . $example[0]);

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $invoice    = new Invoices($connection);

        $result = $invoice->insert($connection, 1, 'test-1');
        $I->assertEquals(1, $result);

        $all = $connection->fetchOne(
            'select * from co_invoices WHERE ' . $example[1],
            $example[2]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
    }

    /**
     * @return array
     */
    private function getBindTypes(): array
    {
        return [
            [
                'numeric',
                'inv_id = ?',
                [0 => 1],
            ],
            [
                'named',
                'inv_id = :id',
                ['id' => 1],
            ],
            [
                'named boolean',
                'inv_status_flag = :status',
                [
                    'status' => true,
                ],
            ],
            [
                'named boolean with type',
                'inv_status_flag = :status',
                [
                    'status' => [true, PDO::PARAM_BOOL],
                ],
            ],
            [
                'named null',
                'inv_id = :id AND inv_status_flag IS NOT :status',
                [
                    'id'     => 1,
                    'status' => null,
                ],
            ],
            [
                'named null with type',
                'inv_id = :id AND inv_status_flag IS NOT :status',
                [
                    'id'     => [1, PDO::PARAM_INT],
                    'status' => [null, PDO::PARAM_NULL],
                ],
            ],
            [
                'named string',
                'inv_title = :title',
                [
                    'title' => 'test-1',
                ],
            ],

        ];
    }
}
