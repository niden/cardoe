<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function cacheAdapterMemoryGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $I->assertNull(
            $adapter->getAdapter()
        );
    }
}
