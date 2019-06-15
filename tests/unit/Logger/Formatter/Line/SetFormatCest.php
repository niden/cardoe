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

class SetFormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Line :: setFormat()
     */
    public function loggerFormatterLineSetFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - setFormat()');
        $formatter = new Line();

        $format = '%message%-[%date%]-[%type%]';
        $formatter->setFormat($format);

        $expected = $format;
        $actual   = $formatter->getFormat();
        $I->assertEquals($expected, $actual);
    }
}
