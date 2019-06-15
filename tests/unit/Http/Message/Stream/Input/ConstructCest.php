<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Stream\Input;

use Cardoe\Http\Message\Stream\Input;
use Psr\Http\Message\StreamInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Stream\Input :: __construct()
     *
     * @since  2019-02-19
     */
    public function httpMessageStreamInputConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Stream\Input - __construct()');
        $request = new Input();
        $class   = StreamInterface::class;
        $I->assertInstanceOf($class, $request);
    }
}
