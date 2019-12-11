<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Parser\PgsqlParser;

use IntegrationTester;

class RebuildCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Parser\PgsqlParser :: rebuild()
     *
     * @since  2019-12-11
     */
    public function dMPdoParserPgsqlParserRebuild(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\PgsqlParser - rebuild()');

        $I->skipTest('Need implementation');
    }
}
