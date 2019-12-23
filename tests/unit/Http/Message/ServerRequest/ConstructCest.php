<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\ServerRequest;

use Phalcon\Http\Message\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Phalcon\Http\Message\ServerRequest :: __construct()
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
