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

use function outputDir;
use function uniqid;

class HasCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: has()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamHas(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - has()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $key = uniqid();

        $actual = $adapter->has($key);
        $I->assertFalse($actual);

        $adapter->set($key, 'test');
        $actual = $adapter->has($key);
        $I->assertTrue($actual);
    }
}
