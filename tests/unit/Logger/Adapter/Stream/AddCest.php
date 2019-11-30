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
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class AddCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: add()
     */
    public function loggerAdapterStreamAdd(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - add()');
        $fileName   = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter    = new Stream($outputPath . $fileName);

        $adapter->begin();
        $item1 = new Item('Message 1', 'debug', Logger::DEBUG);
        $item2 = new Item('Message 2', 'debug', Logger::DEBUG);
        $item3 = new Item('Message 3', 'debug', Logger::DEBUG);

        $adapter
            ->add($item1)
            ->add($item2)
            ->add($item3)
        ;

        $I->amInPath($outputPath);
        $I->dontSeeFileFound($fileName);

        $adapter->commit();

        $I->amInPath($outputPath);
        $I->seeFileFound($fileName);
        $I->openFile($fileName);
        $I->seeInThisFile('Message 1');
        $I->seeInThisFile('Message 2');
        $I->seeInThisFile('Message 3');

        $I->safeDeleteFile($outputPath . $fileName);
    }
}
