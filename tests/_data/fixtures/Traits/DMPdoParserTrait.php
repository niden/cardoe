<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Traits;

use Codeception\Example;
use IntegrationTester;
use Phalcon\DM\Pdo\Parser\ParserInterface;

trait DMPdoParserTrait
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\MysqlParser :: rebuild()
     *
     * @dataProvider getExamples
     *
     * @param IntegrationTester $I
     * @param Example           $example
     *
     * @since        2019-12-11
     */
    public function dMPdoParserMysqlParserRebuild(IntegrationTester $I, Example $example)
    {
        $I->wantToTest('DM\Pdo\Parser\MysqlParser - rebuild() - ' . $example[0]);

        [$statement, $values] = $this->rebuild($example[1], $example[2]);
        $I->assertEquals($example[3], $statement);
        $I->assertEquals($example[4], $values);
    }

    /**
     * @return array
     */
    protected function getExamples(): array
    {
        return [
            [
                'multiple named parameters',
                "select :id as a, :id as b",
                ['id' => 'inv_id'],
                "select :id as a, :id__1 as b",
                ['id' => 'inv_id', 'id__1' => 'inv_id'],
            ],
            [
                'multiple numbered parameters',
                "select ? as a, ? as b from co_invoices where inv_id = ?",
                ['inv_id', 'inv_total', null],
                "select :__1 as a, :__2 as b from co_invoices where inv_id = :__3",
                ['__1' => 'inv_id', '__2' => 'inv_total', '__3' => null],
            ],
            [
                'array as parameter',
                "select :id",
                ['id' => [1, 2]],
                "select :id_0, :id_1",
                ['id_0' => 1, 'id_1' => 2],
            ],
            [
                'double quoted identifier',
                'select ":id"',
                ['id' => [1, 2]],
                'select ":id"',
                [],
            ],
            [
                'statement with double quotes',
                'select "to use double quotes, just double them "" :id',
                ['id' => [1, 2]],
                'select "to use double quotes, just double them "" :id',
                [],
            ],
            [
                'single quoted identifier',
                "select ':id'",
                ['id' => [1, 2]],
                "select ':id'",
                [],
            ],
            [
                'statement with single quotes',
                "select 'single quote''s :id'",
                ['id' => [1, 2]],
                "select 'single quote''s :id'",
                [],
            ],
            [
                'multiline statement with single quotes',
                "select 'multi line string'
':id'
'title'",
                ['id' => [1, 2]],
                "select 'multi line string'
':id'
'title'",
                [],
            ],
            [
                'single quotes escape',
                "'select Escaping \' :id \'",
                ['id' => [1, 2]],
                "'select Escaping \' :id \'",
                [],
            ],
            [
                'double quotes escape',
                '"select Escaping \" :id \""',
                ['id' => [1, 2]],
                '"select Escaping \" :id \""',
                [],
            ],
            [
                'double quotes double escape',
                'select "Escaping \\\\" :id ""',
                ['id' => ['one', 'two']],
                'select "Escaping \\\\" :id ""',
                [],
            ],
            [
                'double quotes escape unterminated',
                'select "Escaping \" :id \"',
                ['id' => [1, 2]],
                'select "Escaping \" :id \"',
                [],
            ],
            [
                'double double quotes',
                'select "Escaping "" :id ""',
                ['id' => [1, 2]],
                'select "Escaping "" :id ""',
                [],
            ],
            [
                'double single quotes escape',
                "select 'Escaping '' :id '''",
                ['id' => [1, 2]],
                "select 'Escaping '' :id '''",
                [],
            ],
            [
                'blank string query',
                "update table " .
                "set `value`= :value, `blank` = '', `value2` =  :value2, " .
                "`blank2` = '', `value3` = :value3 " .
                "where id = :id",
                [
                    'value'  => 'string',
                    'id'     => 1,
                    'value2' => 'string',
                    'value3' => 'string',
                ],
                "update table " .
                "set `value`= :value, `blank` = '', `value2` =  :value2, " .
                "`blank2` = '', `value3` = :value3 " .
                "where id = :id",
                [
                    'value'  => 'string',
                    'id'     => 1,
                    'value2' => 'string',
                    'value3' => 'string',
                ],
            ],
        ];
    }

    /**
     * Rebuild the parser
     *
     * @param string $sql
     * @param array  $parameters
     *
     * @return array
     */
    protected function rebuild(string $sql, array $parameters)
    {
        $parser = clone $this->parser;
        return $parser->rebuild($sql, $parameters);
    }
}
