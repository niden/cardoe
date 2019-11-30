<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Stream;

use Cardoe\Logger\Adapter\Stream;
use UnitTester;

class GetNameCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: getName()
     */
    public function loggerAdapterStreamGetName(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - getName()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $expected = $outputPath . $fileName;
        $actual   = $adapter->getName();
        $I->assertEquals($expected, $actual);

        $I->safeDeleteFile($outputPath . $fileName);
    }
}
