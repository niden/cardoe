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
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Line;
use UnitTester;

class SetFormatterCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Stream :: setFormatter()
     */
    public function loggerAdapterStreamSetFormatter(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Stream - setFormatter()');

        $fileName = $I->getNewFileName('log', 'log');
        $fileName = logsDir($fileName);

        $adapter = new Stream($fileName);

        $adapter->setFormatter(
            new Line()
        );

        $actual = $adapter->getFormatter();

        $I->assertInstanceOf(
            FormatterInterface::class,
            $actual
        );

        $I->safeDeleteFile($fileName);
    }
}
