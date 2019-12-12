<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Parser\SqlsrvParser;

use IntegrationTester;

class RebuildCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Parser\SqlsrvParser :: rebuild()
     *
     * @since  2019-12-11
     */
    public function dMPdoParserSqlsrvParserRebuild(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\SqlsrvParser - rebuild()');

        $I->skipTest('Need implementation');
    }
}