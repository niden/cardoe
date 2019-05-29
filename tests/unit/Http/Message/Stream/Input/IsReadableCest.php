<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream\Input;

use Cardoe\Http\Message\Stream\Input;
use UnitTester;

class IsReadableCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Input :: isReadable()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamInputIsReadable(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - isReadable()');

        $stream = new Input();

        $I->assertTrue(
            $stream->isReadable()
        );
    }
}
