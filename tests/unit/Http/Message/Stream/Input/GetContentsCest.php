<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Stream\Input;

use UnitTester;

class GetContentsCest
{
    /**
     * Unit Tests Cardoe\Http\Message\Stream\Input :: getContents()
     *
     * @since  2019-05-25
     */
    public function httpMessageStreamInputGetContents(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - getContents()');

        $I->skipTest('Need implementation');
    }
}
