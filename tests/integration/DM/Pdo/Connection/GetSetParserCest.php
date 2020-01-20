<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Connection;

use IntegrationTester;
use Phalcon\DM\Pdo\Connection;
use Phalcon\DM\Pdo\Parser\SqliteParser;

class GetSetParserCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Connection :: getParser()/setParser()
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
            sprintf('Phalcon\DM\Pdo\Parser\%sParser', $adapter),
            $connection->getParser()
        );

        $parser = new SqliteParser();
        $connection->setParser($parser);

        $I->assertSame($parser, $connection->getParser());
    }
}
