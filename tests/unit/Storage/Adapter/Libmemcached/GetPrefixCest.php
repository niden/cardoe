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

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;

use function getOptionsLibmemcached;

class GetPrefixCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterLibmemcachedGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - getPrefix()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            array_merge(
                getOptionsLibmemcached(),
                [
                    'prefix' => 'my-prefix',
                ]
            )
        );

        $I->assertEquals(
            'my-prefix',
            $adapter->getPrefix()
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterLibmemcachedGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - getPrefix() - default');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $I->assertEquals(
            'ph-memc-',
            $adapter->getPrefix()
        );
    }
}
