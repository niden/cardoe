<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream\Temp;

use Cardoe\Http\Message\Stream\Temp;
use UnitTester;

class IsSeekableCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Temp :: isSeekable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamTempIsSeekable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Temp - isSeekable()');

        $stream = new Temp();

        $I->assertTrue(
            $stream->isSeekable()
        );
    }
}
