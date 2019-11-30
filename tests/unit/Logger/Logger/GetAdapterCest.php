<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Logger;

use Cardoe\Logger\Adapter\Stream;
use Cardoe\Logger\Exception;
use Cardoe\Logger\Logger;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Logger :: getAdapter()
     */
    public function loggerGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Logger - getAdapter()');
        $fileName1  = $I->getNewFileName('log', 'log');
        $outputPath = logsDir();
        $adapter1   = new Stream($outputPath . $fileName1);

        $logger = new Logger(
            'my-logger',
            [
                'one' => $adapter1,
            ]
        );


        $class  = Stream::class;
        $actual = $logger->getAdapter('one');
        $I->assertInstanceOf($class, $actual);

        $I->safeDeleteFile($outputPath . $fileName1);
    }

    /**
     * Tests Cardoe\Logger :: getAdapter() - unknown
     */
    public function loggerGetAdapterUnknown(UnitTester $I)
    {
        $I->wantToTest('Logger - getAdapter() - unknown');

        $I->expectThrowable(
            new Exception('Adapter does not exist for this logger'),
            function () {
                $logger = new Logger('my-logger');
                $logger->getAdapter('unknown');
            }
        );
    }
}
