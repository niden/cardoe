<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Formatter\Line;

use Cardoe\Logger\Formatter\Line;
use UnitTester;

class GetFormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Line :: getFormat()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterLineGetFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - getFormat()');

        $formatter = new Line();

        $I->assertEquals(
            '[%date%][%type%] %message%',
            $formatter->getFormat()
        );
    }
}
