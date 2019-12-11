<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Parser\AbstractParser;

use IntegrationTester;

class RebuildCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Parser\AbstractParser :: rebuild()
     *
     * @since  2019-12-11
     */
    public function dMPdoParserAbstractParserRebuild(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Parser\AbstractParser - rebuild()');

        $I->skipTest('Need implementation');
    }
}
