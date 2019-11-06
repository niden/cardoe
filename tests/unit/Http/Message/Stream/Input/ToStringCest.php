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

namespace Phalcon\Test\Unit\Http\Message\Stream\Input;

use UnitTester;

class ToStringCest
{
    /**
     * Unit Tests Phalcon\Http\Message\Stream\Input :: __toString()
     *
     * @since  2019-05-25
     */
    public function httpMessageStreamInputToString(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - __toString()');

        skipTest('Need implementation');
    }
}
