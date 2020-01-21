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
use Phalcon\DM\Query\QueryFactory;

class QuoteIdentifierCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Select :: quoteIdentifier()
     *
     * @since  2020-01-20
     */
    public function dMQuerySelectQuoteIdentifier(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Select - quoteIdentifier()');

        $connection = $I->getConnection();
        $factory    = new QueryFactory();
        $select     = $factory->newSelect($connection);

        $quotes   = $connection->getQuoteNames();
        $source   = 'some field';
        $expected = $quotes['prefix'] . $source . $quotes['suffix'];
        $actual   = $select->quoteIdentifier($source);
        $I->assertEquals($expected, $actual);
    }
}
