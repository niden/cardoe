<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\StreamFactory;

use Cardoe\Http\Message\StreamFactory;
use Psr\Http\Message\StreamFactoryInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\StreamFactory :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpStreamFactoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\StreamFactory - __construct()');

        $factory = new StreamFactory();
        $class   = StreamFactoryInterface::class;
        $I->assertInstanceOf($class, $factory);
    }
}
