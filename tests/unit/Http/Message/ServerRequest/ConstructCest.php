<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpMessageServerRequestConstructCest(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - __construct()');
        $request = new ServerRequest();
        $class   = ServerRequestInterface::class;
        $I->assertInstanceOf($class, $request);
    }
}
