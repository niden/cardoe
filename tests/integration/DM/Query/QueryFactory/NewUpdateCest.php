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
use Phalcon\DM\Query\QueryFactory;
use Phalcon\DM\Query\Update;

class NewUpdateCest
{
    /**
     * Integration Tests Phalcon\DM\Query\QueryFactory :: newUpdate()
     *
     * @since  2020-01-20
     */
    public function dMQueryQueryFactoryNewUpdate(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\QueryFactory - newUpdate()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $update     = $factory->newUpdate($connection);
        $I->assertInstanceOf(Update::class, $update);
    }
}
