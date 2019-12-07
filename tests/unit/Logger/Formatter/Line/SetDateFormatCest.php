<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Formatter\Line;

use Cardoe\Logger\Formatter\Line;
use UnitTester;

class SetDateFormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Line :: setDateFormat()
     */
    public function loggerFormatterLineSetDateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - setDateFormat()');
        $formatter = new Line();

        $format = 'YmdHis';
        $formatter->setDateFormat($format);

        $expected = $format;
        $actual   = $formatter->getDateFormat();
        $I->assertEquals($expected, $actual);
    }
}
