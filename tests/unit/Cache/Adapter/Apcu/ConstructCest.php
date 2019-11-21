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

namespace Cardoe\Test\Unit\Cache\Adapter\Apcu;

use Cardoe\Cache\Adapter\AdapterInterface;
use Cardoe\Cache\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class ConstructCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function cacheAdapterApcuConstruct(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - __construct()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $I->assertInstanceOf(
            Apcu::class,
            $adapter
        );

        $I->assertInstanceOf(
            AdapterInterface::class,
            $adapter
        );
    }
}
