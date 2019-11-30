<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Line;
use UnitTester;

class GetFormatterCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: getFormatter()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopGetFormatter(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - getFormatter()');

        $adapter = new Noop();

        $adapter->getFormatter(
            new Line()
        );

        $I->assertInstanceOf(
            FormatterInterface::class,
            $adapter->getFormatter()
        );
    }
}
