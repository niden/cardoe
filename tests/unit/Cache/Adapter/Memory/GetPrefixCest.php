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

class GetPrefixCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - getPrefix()');

        $serializer = new SerializerFactory();

        $adapter = new Memory(
            $serializer,
            [
                'prefix' => 'my-prefix',
            ]
        );

        $I->assertEquals(
            'my-prefix',
            $adapter->getPrefix()
        );
    }

    /**
     * Tests Cardoe\Cache\Adapter\Memory :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterMemoryGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $I->assertEquals(
            'ph-memo-',
            $adapter->getPrefix()
        );
    }
}
