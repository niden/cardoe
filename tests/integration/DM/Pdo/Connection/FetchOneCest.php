<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Exception\CannotBindValue;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use Codeception\Example;
use IntegrationTester;
use stdClass;

class FetchOneCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: fetchOne()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionFetchOne(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne()');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
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
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne() - no result
     *
     * @since  2019-11-16
     */
    public function dMPdoConnectionFetchOneNoResult(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - no result');

        $result = $this->newInvoice(1);
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE inv_id = ?',
            [
                0 => 7,
            ]
        );

        $I->assertIsArray($all);
        $I->assertIsEmpty($all);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne() - bind types
     *
     * @dataProvider getBindTypes
     * @since  2019-11-16
     */
    public function dMPdoConnectionFetchOneBindTypes(IntegrationTester $I, Example $example)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - bind types - ' . $example[0]);

        $result = $this->newInvoice(1, 'test-1');
        $I->assertEquals(1, $result);

        $all = $this->connection->fetchOne(
            'select * from co_invoices WHERE ' . $example[1],
            $example[2]
        );

        $I->assertIsArray($all);
        $I->assertEquals(1, $all['inv_id']);
    }

    /**
     * Tests Cardoe\DM\Pdo\Connection :: fetchOne() - bind types exception
     *
     * @since  2019-11-16
     */
    public function dMPdoConnectionFetchOneBindTypesException(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - fetchOne() - bind types - exception');

        $I->expectThrowable(
            new CannotBindValue(
                "Cannot bind value of type 'object' to placeholder 'id'"
            ),
            function () use ($I) {
                $result = $this->newInvoice(1);
                $I->assertEquals(1, $result);

                $all = $this->connection->fetchOne(
                    'select * from co_invoices WHERE inv_id = :id',
                    [
                        'id' => new stdClass(),
                    ]
                );
            }
        );
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
                ['status' => true],
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
                'named string',
                'inv_title = :title',
                [
                    'title' => 'test-1',
                ],
            ],

        ];
    }
}
