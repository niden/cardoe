<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequestFactory;

use Cardoe\Http\Message\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use UnitTester;

class CreateServerRequestCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequestFactory :: createServerRequest()
     *
     * @since  2019-02-09
     */
    public function httpMessageServerRequestFactoryCreateServerRequest(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequestFactory - createServerRequest()');

        $factory = new ServerRequestFactory();
        $request = $factory->createServerRequest('GET', '');
        $class   = ServerRequestInterface::class;
        $I->assertInstanceOf($class, $request);
    }
}
