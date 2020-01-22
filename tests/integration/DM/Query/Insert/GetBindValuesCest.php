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

namespace Phalcon\Test\Integration\DM\Query\Insert;

use IntegrationTester;
use PDO;
use Phalcon\DM\Query\QueryFactory;

class GetBindValuesCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Insert :: getBindValues()
     *
     * @since  2020-01-20
     */
    public function dMQueryInsertGetBindValues(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Insert - getBindValues()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $insert     = $factory->newInsert($connection);

        $expected = [];
        $actual   = $insert->getBindValues();
        $I->assertEquals($expected, $actual);

        $insert
            ->bindValues(
                [
                    'one'   => 100,
                    'two'   => null,
                    'three' => true,
                    'four'  => [1, 2, 3],
                ]
            );

        $expected = [
            'one'   => [100, PDO::PARAM_INT],
            'two'   => [null, PDO::PARAM_NULL],
            'three' => [true, PDO::PARAM_BOOL],
            'four'  => [[1, 2, 3], PDO::PARAM_STR],
        ];
        $actual   = $insert->getBindValues();
        $I->assertEquals($expected, $actual);

        $insert
            ->bindValues(
                [
                    'five' => 'active',
                ]
            );

        $expected = [
            'one'   => [100, PDO::PARAM_INT],
            'two'   => [null, PDO::PARAM_NULL],
            'three' => [true, PDO::PARAM_BOOL],
            'four'  => [[1, 2, 3], PDO::PARAM_STR],
            'five'  => ['active', PDO::PARAM_STR],
        ];
        $actual   = $insert->getBindValues();
        $I->assertEquals($expected, $actual);
    }
}
