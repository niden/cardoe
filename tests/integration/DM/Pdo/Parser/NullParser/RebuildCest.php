<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Pdo\Parser\NullParser;

use IntegrationTester;
use Phalcon\DM\Pdo\Parser\NullParser;
use Phalcon\Test\Fixtures\Traits\DMPdoParserTrait;

class RebuildCest
{
    /**
     * Integration Tests Phalcon\DM\Pdo\Parser\NullParser :: rebuild() - backticks
     *
     * @since  2019-12-25
     */
    public function dMPdoParserNullParserRebuildBackticks(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\NullParser - rebuild()');

        $parser = new NullParser();

        $sql        = 'select `single quote``s :id``';
        $parameters = ['id' => ['one', 'two']];

        [$statement, $values] = $parser->rebuild($sql, $parameters);
        $I->assertEquals($sql, $statement);
        $I->assertEquals($parameters, $values);
    }
}
