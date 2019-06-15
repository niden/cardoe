<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream\Input;

use UnitTester;

class ToStringCest
{
    /**
     * Unit Tests Cardoe\Http\Message\Stream\Input :: __toString()
     *
     * @since  2019-05-25
     */
    public function httpMessageStreamInputToString(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - __toString()');

        $I->skipTest('Need implementation');
    }
}
