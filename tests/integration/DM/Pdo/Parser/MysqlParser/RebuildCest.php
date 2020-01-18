<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Parser\MysqlParser;

use IntegrationTester;
use Phalcon\DM\Pdo\Exception\MissingParameter;
use Phalcon\DM\Pdo\Parser\MysqlParser;
use Phalcon\Test\Fixtures\Traits\DMPdoParserTrait;

class RebuildCest
{
    use DMPdoParserTrait;

    public function _before()
    {
        $this->parser = new MysqlParser();
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\MysqlParser :: rebuild() -
     * backticks
     *
     * @since  2019-12-25
     */
    public function dMPdoParserMysqlParserRebuildBackticks(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\MysqlParser - rebuild() - backticks');

        $sql        = 'select `:id`';
        $parameters = ['id' => ['bar', 'baz']];

        [$statement, $values] = $this->rebuild($sql, $parameters);
        $I->assertEquals($sql, $statement);
        $I->assertEquals([], $values);

        $sql        = 'select `single quote``s :id``';
        $parameters = ['id' => ['bar', 'baz']];

        [$statement, $values] = $this->rebuild($sql, $parameters);
        $I->assertEquals($sql, $statement);
        $I->assertEquals([], $values);
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\MysqlParser :: rebuild() -
     * exception missing named parameter
     *
     * @since  2019-12-25
     */
    public function dMPdoParserMysqlParserRebuildExceptionMissingNamedParameter(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\MysqlParser - rebuild() - exception missing named parameter');

        $I->expectThrowable(
            new MissingParameter(
                "Parameter 'three' is missing from the bound values"
            ),
            function () {
                $sql        = 'select :one :two :three';
                $parameters = ['one' => 1, 'two' => 2, 'four' => 4];

                $this->rebuild($sql, $parameters);
            }
        );
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\MysqlParser :: rebuild() -
     * exception missing numeric parameter
     *
     * @since  2019-12-25
     */
    public function dMPdoParserMysqlParserRebuildExceptionMissingNumericParameter(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\MysqlParser - rebuild() - exception missing numeric parameter');

        $I->expectThrowable(
            new MissingParameter(
                "Parameter '3' is missing from the bound values"
            ),
            function () {
                $sql        = 'select ? ? ?';
                $parameters = [1 => 'one', 2 => 'two', 4 => 'four'];

                [$statement, $values] = $this->rebuild($sql, $parameters);
            }
        );
    }
}
