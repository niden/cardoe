<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Logger\Formatter\Json;

use Cardoe\Logger\Formatter\Json;
use UnitTester;

class SetDateFormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Json :: setDateFormat()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonSetDateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - setDateFormat()');

        $formatter = new Json();

        $format = 'YmdHis';

        $formatter->setDateFormat($format);

        $I->assertEquals(
            $format,
            $formatter->getDateFormat()
        );
    }
}
