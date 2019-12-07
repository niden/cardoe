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

class GetDateFormatCest
{
    /**
     * Tests Cardoe\Logger\Formatter\Json :: getDateFormat()
     *
     * @since  2018-11-13
     */
    public function loggerFormatterJsonGetDateFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Json - getDateFormat()');

        $formatter = new Json();

        $I->assertEquals(
            'D, d M y H:i:s O',
            $formatter->getDateFormat()
        );
    }
}
