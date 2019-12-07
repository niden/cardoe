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
use Psr\Http\Message\ServerRequestFactoryInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequestFactory :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpServerRequestFactoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\ServerRequestFactory - __construct()');

        $factory = new ServerRequestFactory();
        $class   = ServerRequestFactoryInterface::class;
        $I->assertInstanceOf($class, $factory);
    }
}
