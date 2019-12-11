<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Parser\MysqlParser;
use Cardoe\DM\Pdo\Parser\SqliteParser;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;

class GetSetParserCest
{
    use ConnectionTrait;

    /**
     * Integration Tests Cardoe\DM\Pdo\Connection :: getParser()/setParser()
     *
     * @since  2019-12-11
     */
    public function dMPdoConnectionGetSetParser(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getParser()/setParser()');

        $I->assertInstanceOf(
            MysqlParser::class,
            $this->connection->getParser()
        );

        $parser = new SqliteParser();
        $this->connection->setParser($parser);

        $I->assertSame($parser, $this->connection->getParser());
    }
}
