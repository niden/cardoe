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
use Phalcon\DM\Query\Insert;
use Phalcon\DM\Query\QueryFactory;

class NewInsertCest
{
    /**
     * Integration Tests Phalcon\DM\Query\QueryFactory :: newInsert()
     *
     * @since  2020-01-20
     */
    public function dMQueryQueryFactoryNewInsert(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\QueryFactory - newInsert()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $insert     = $factory->newInsert($connection);
        $I->assertInstanceOf(Insert::class, $insert);
    }
}
