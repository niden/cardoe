<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Stream;

use Cardoe\Logger\Adapter\Stream;
use UnitTester;

class BeginCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: begin()
     */
    public function loggerAdapterStreamBegin(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - begin()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $adapter->begin();

        $actual = $adapter->inTransaction();
        $I->assertTrue($actual);

        $I->safeDeleteFile($outputPath . $fileName);
    }
}
