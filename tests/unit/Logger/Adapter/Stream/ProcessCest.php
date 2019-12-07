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
use Cardoe\Logger\Exception;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class ProcessCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: process()
     *
     * @throws Exception
     */
    public function loggerAdapterStreamProcess(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - process()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $item = new Item('Message 1', 'debug', Logger::DEBUG);
        $adapter->process($item);

        $I->amInPath($outputPath);
        $I->seeFileFound($fileName);
        $I->openFile($fileName);
        $I->seeInThisFile('Message 1');

        $I->safeDeleteFile($outputPath . $fileName);
    }
}
