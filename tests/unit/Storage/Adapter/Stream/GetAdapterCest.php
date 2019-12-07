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

namespace Cardoe\Test\Unit\Storage\Adapter\Stream;

use Cardoe\Storage\Adapter\Stream;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

class GetAdapterCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - getAdapter()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => '/tmp',
            ]
        );

        $I->assertNull(
            $adapter->getAdapter()
        );
    }
}
