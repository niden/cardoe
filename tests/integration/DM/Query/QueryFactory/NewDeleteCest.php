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

namespace Phalcon\Test\Integration\DM\Query\QueryFactory;

use IntegrationTester;
use Phalcon\DM\Query\Delete;
use Phalcon\DM\Query\QueryFactory;

class NewDeleteCest
{
    /**
     * Integration Tests Phalcon\DM\Query\QueryFactory :: newDelete()
     *
     * @since  2020-01-20
     */
    public function dMQueryQueryFactoryNewDelete(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\QueryFactory - newDelete()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $delete     = $factory->newDelete($connection);
        $I->assertInstanceOf(Delete::class, $delete);
    }
}
