<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Apcu;

use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class GetAdapterCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function cacheAdapterApcuGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $I->assertNull(
            $adapter->getAdapter()
        );
    }
}
