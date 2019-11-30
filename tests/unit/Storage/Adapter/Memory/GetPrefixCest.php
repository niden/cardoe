<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Memory;

use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetPrefixCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Memory :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterMemoryGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - getPrefix()');

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
     * Tests Cardoe\Storage\Adapter\Memory :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterMemoryGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $I->assertEquals(
            'ph-memo-',
            $adapter->getPrefix()
        );
    }
}
