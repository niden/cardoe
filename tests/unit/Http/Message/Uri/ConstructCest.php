<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Uri;

use Phalcon\Http\Message\Uri;
use Psr\Http\Message\UriInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: __construct()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - __construct()');

        $uri   = new Uri();
        $class = UriInterface::class;
        $I->assertInstanceOf($class, $uri);
    }
}
