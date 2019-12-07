<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\AdapterInterface;
use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function cacheAdapterMemoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - __construct()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $I->assertInstanceOf(
            Memory::class,
            $adapter
        );

        $I->assertInstanceOf(
            AdapterInterface::class,
            $adapter
        );
    }
}
