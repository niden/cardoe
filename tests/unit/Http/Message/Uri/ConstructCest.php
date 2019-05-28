<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use Psr\Http\Message\UriInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: __construct()
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
