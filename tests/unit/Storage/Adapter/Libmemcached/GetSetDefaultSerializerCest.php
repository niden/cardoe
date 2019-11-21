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

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;
use function getOptionsLibmemcached;

class GetSetDefaultSerializerCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached ::
     * getDefaultSerializer()/setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterLibmemcachedGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - getDefaultSerializer()/setDefaultSerializer()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

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
