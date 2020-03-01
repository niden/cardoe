<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Logger\Adapter\Stream;

use Codeception\Stub;
use LogicException;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Exception;
use Phalcon\Logger\Item;
use UnitTester;

use function logsDir;

class ProcessCest
{
    /**
     * Tests Phalcon\Logger\Adapter\Stream :: process()
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

        $adapter->close();
        $I->safeDeleteFile($outputPath . $fileName);
    }

    /**
     * Tests Phalcon\Logger\Adapter\Stream :: process() - exception
     *
     * @throws Exception
     */
    public function loggerAdapterStreamProcessException(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - process() - exception');

        $fileName    = $I->getNewFileName('log', 'log');
        $outputPath  = logsDir();

        $I->expectThrowable(
            new LogicException(
                "The file '" . $outputPath . $fileName
                . "' cannot be opened with mode 'ab'"
            ),
            function () use ($outputPath, $fileName) {
                $adapter = Stub::construct(
                    Stream::class,
                    [
                        $outputPath . $fileName
                    ],
                    [
                        'fopen' => false,
                    ]
                );

                $item = new Item('Message 1', 'debug', Logger::DEBUG);
                $adapter->process($item);
            }
        );

        $I->safeDeleteFile($outputPath . $fileName);
    }
}
