<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream\Temp;

use Cardoe\Http\Message\Stream\Temp;
use UnitTester;

class IsWritableCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Temp :: isWritable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamTempIsWritable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Temp - isWritable()');

        $stream = new Temp('r+b');

        $I->assertTrue(
            $stream->isWritable()
        );
    }
}
