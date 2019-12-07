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

namespace Cardoe\Test\Unit\Cache\Adapter\Libmemcached;

use Memcached;
use Cardoe\Cache\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;

use function getOptionsLibmemcached;

class GetAdapterCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Libmemcached :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function cacheAdapterLibmemcachedGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Libmemcached($serializer, getOptionsLibmemcached());

        $I->assertInstanceOf(
            Memcached::class,
            $adapter->getAdapter()
        );
    }
}
