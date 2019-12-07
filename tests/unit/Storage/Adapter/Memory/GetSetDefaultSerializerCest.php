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

namespace Cardoe\Test\Unit\Storage\Adapter\Memory;

use Cardoe\Storage\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetSetDefaultSerializerCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Memory ::
     * getDefaultSerializer()/setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterMemoryGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - getDefaultSerializer()/setDefaultSerializer()');

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $I->assertEquals(
            'Php',
            $adapter->getDefaultSerializer()
        );

        $adapter->setDefaultSerializer('Base64');

        $I->assertEquals(
            'Base64',
            $adapter->getDefaultSerializer()
        );
    }
}
