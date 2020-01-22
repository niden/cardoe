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

namespace Phalcon\Test\Integration\DM\Query\Update;

use IntegrationTester;
use Phalcon\DM\Query\QueryFactory;

class HasColumnsCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Update :: hasColumns()
     *
     * @since  2020-01-20
     */
    public function dMQueryUpdateHasColumns(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Update - hasColumns()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $update     = $factory->newUpdate($connection);

        $actual = $update->hasColumns();
        $I->assertFalse($actual);

        $update->columns(['inv_id', 'inv_total']);

        $actual = $update->hasColumns();
        $I->assertTrue($actual);
    }
}
