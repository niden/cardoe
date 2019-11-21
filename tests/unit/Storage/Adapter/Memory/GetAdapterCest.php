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

namespace Cardoe\Test\Unit\Storage\Adapter\Memory;

use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Memory :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function storageAdapterMemoryGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $actual = $adapter->getAdapter();
        $I->assertNull($actual);
    }
}
