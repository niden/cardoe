<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Stream\Temp;

use Phalcon\Http\Message\Stream\Temp;
use UnitTester;

class IsReadableCest
{
    /**
     * Tests Phalcon\Http\Message\Stream\Temp :: isReadable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamTempIsReadable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Temp - isReadable()');

        $stream = new Temp();

        $I->assertTrue(
            $stream->isReadable()
        );
    }
}
