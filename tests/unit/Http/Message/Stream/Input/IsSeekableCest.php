<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream\Input;

use Cardoe\Http\Message\Stream\Input;
use UnitTester;

class IsSeekableCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Input :: isSeekable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamInputIsSeekable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - isSeekable()');

        $stream = new Input();

        $I->assertTrue(
            $stream->isSeekable()
        );
    }
}
