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

use Cardoe\Storage\Adapter\AdapterInterface;
use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Memory :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function storageAdapterMemoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - __construct()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $class = Memory::class;
        $I->assertInstanceOf($class, $adapter);

        $class = AdapterInterface::class;
        $I->assertInstanceOf($class, $adapter);
    }
}
