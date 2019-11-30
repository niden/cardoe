<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\RequestFactory;

use Cardoe\Http\Message\Request;
use Psr\Http\Message\RequestInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpMessageRequestConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - __construct()');

        $request = new Request();

        $I->assertInstanceOf(
            RequestInterface::class,
            $request
        );
    }
}
