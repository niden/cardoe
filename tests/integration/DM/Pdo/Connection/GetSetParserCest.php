<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use Cardoe\DM\Pdo\Parser\SqliteParser;
use IntegrationTester;

class GetSetParserCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getParser()/setParser()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetSetParser(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getParser()/setParser()');

        /** @var Connection $connection */
        $connection = $I->getConnection();
        $adapter    = $I->getAdapter();

        $I->assertInstanceOf(
            sprintf('Cardoe\DM\Pdo\Parser\%sParser', $adapter),
            $connection->getParser()
        );

        $parser = new SqliteParser();
        $connection->setParser($parser);

        $I->assertSame($parser, $connection->getParser());
    }

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getParser()/setParser() default
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetSetParserDefault(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getParser()/setParser() - default');

        $connection = new Connection(
            'random:some data'
        );

        $I->assertInstanceOf(
            SqliteParser::class,
            $connection->getParser()
        );
    }
}
