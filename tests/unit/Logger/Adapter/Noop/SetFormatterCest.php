<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Line;
use UnitTester;

class SetFormatterCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: setFormatter()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopSetFormatter(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - setFormatter()');

        $adapter = new Noop();

        $adapter->setFormatter(
            new Line()
        );

        $I->assertInstanceOf(
            FormatterInterface::class,
            $adapter->getFormatter()
        );
    }
}
