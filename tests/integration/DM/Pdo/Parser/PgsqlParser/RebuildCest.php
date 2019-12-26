<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Parser\PgsqlParser;

use IntegrationTester;
use Phalcon\DM\Pdo\Parser\PgsqlParser;
use Phalcon\Test\Fixtures\Traits\DMPdoParserTrait;

class RebuildCest
{
    use DMPdoParserTrait;

    public function _before()
    {
        $this->parser = new PgsqlParser();
    }

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\PgsqlParser :: rebuild() - backticks
     *
     * @since  2019-12-25
     */
    public function dMPdoParserPgsqlParserRebuildBackticks(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\PgsqlParser - rebuild() - backticks');

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

    private function getExamples(): array
    {
        $sql = <<<SQL
SELECT U&"\a000"
FROM (SELECT 1 AS U&":a000" UEScAPE ':') AS temp
SQL;

        $sql2 = <<<SQL
select test[1:2]
from (
select cast('{"one", "two", "three", "four"}' as TEXT[]) as test
) as t
SQL;

        return [
            [
                "unicode double quote identifier",
                $sql,
                ['id' => ['one', 'two']],
                $sql,
                []
            ],
            [
                "c style string constants",
                "select E'C-style escaping \' :id \''",
                ['a000' => ['one', 'two']],
                "select E'C-style escaping \' :id \''",
                []
            ],
            [
                "c style string constants multiline",
                "select E'Multiline'
       'C-style escaping \' :id \' :id'",
                ['id' => ['one', 'two']],
                "select E'Multiline'
       'C-style escaping \' :id \' :id'",
                []
            ],
            [
                "double dollar quoted",
                'select $$:id$$',
                ['id' => ['one', 'two']],
                'select $$:id$$',
                []
            ],
            [
                "single dollar quote two parameters",
                'select $tag$ :foo $tag$',
                ['id' => ['one', 'two']],
                'select $tag$ :foo $tag$',
                []
            ],
            [
                "single dollar nested",
                'select $outer$ nested strings $inner$:foo$inner$ $outer$',
                ['id' => ['one', 'two']],
                'select $outer$ nested strings $inner$:foo$inner$ $outer$',
                []
            ],
            [
                "single dollar utf8",
                'select $€$hello$€$',
                ['hello' => ['one', 'two']],
                'select $€$hello$€$',
                []
            ],
            [
                "single dollar utf8 unaligned pairs",
                'select $€$hello$€',
                ['hello' => ['one', 'two']],
                'select $€$hello$€',
                []
            ],
            [
                "type casting",
                "SELECT 'hello'::TEXT",
                ['TEXT' => ['one', 'two']],
                "SELECT 'hello'::TEXT",
                []
            ],
            [
                "array accessor",
                $sql2,
                ['2' => ['one', 'two']],
                $sql2,
                []
            ],
            [
                "invalid placeholder name",
                "SELECT 'hello':]",
                [']' => ['one', 'two']],
                "SELECT 'hello':]",
                []
            ],
        ];
    }
}
