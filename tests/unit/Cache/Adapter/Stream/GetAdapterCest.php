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

namespace Cardoe\Test\Unit\Cache\Adapter\Stream;

use Cardoe\Cache\Adapter\Stream;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => '/tmp']);

        $actual = $adapter->getAdapter();
        $I->assertNull($actual);
    }
}
