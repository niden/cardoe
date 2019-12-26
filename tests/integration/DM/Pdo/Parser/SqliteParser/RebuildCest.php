<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Parser\SqliteParser;

use IntegrationTester;
use Phalcon\DM\Pdo\Parser\SqliteParser;
use Phalcon\Test\Fixtures\Traits\DMPdoParserTrait;

class RebuildCest
{
    use DMPdoParserTrait;

    public function _before()
    {
        $this->parser = new SqliteParser();
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\SqliteParser :: rebuild() - backticks
     *
     * @since  2019-12-25
     */
    public function dMPdoParserSqliteParserRebuildBackticks(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\SqliteParser - rebuild() - backticks');

        $sql            = 'select `:id`';
        $parameters     = ['id' => ['one', 'two']];
        $expectedSql    = 'select `:id_0, :id_1`';
        $expectedParams = [
            'id_0' => 'one',
            'id_1' => 'two',
        ];

        [$statement, $values] = $this->rebuild($sql, $parameters);
        $I->assertEquals($expectedSql, $statement);
        $I->assertEquals($expectedParams, $values);

        $sql         = 'select `single quote``s :id``';
        $expectedSql = 'select `single quote``s :id_0, :id_1``';
        [$statement, $values] = $this->rebuild($sql, $parameters);
        $I->assertEquals($expectedSql, $statement);
        $I->assertEquals($expectedParams, $values);
    }
}
