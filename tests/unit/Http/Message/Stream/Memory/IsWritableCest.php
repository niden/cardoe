<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Stream\Memory;

use Phalcon\Http\Message\Stream\Memory;
use UnitTester;

class IsWritableCest
{
    /**
     * Tests Phalcon\Http\Message\Stream\Memory :: isWritable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamMemoryIsWritable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Memory - isWritable()');

        $stream = new Memory('r+b');

        $I->assertTrue(
            $stream->isWritable()
        );
    }
}
