<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Cache;

use Cardoe\Cache\Adapter\AdapterInterface;
use Cardoe\Cache\AdapterFactory;
use Cardoe\Cache\Cache;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Cache :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-01
     */
    public function cacheCacheGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Cache - getAdapter()');

        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $instance   = $factory->newInstance('apcu');

        $adapter = new Cache($instance);

        $I->assertInstanceOf(
            AdapterInterface::class,
            $adapter->getAdapter()
        );
    }
}
