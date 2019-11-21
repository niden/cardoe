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

namespace Cardoe\Test\Unit\Storage\Adapter\Apcu;

use Cardoe\Storage\Adapter\AdapterInterface;
use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class ConstructCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-09
     */
    public function storageAdapterApcuConstruct(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - __construct()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $class = Apcu::class;
        $I->assertInstanceOf($class, $adapter);

        $class = AdapterInterface::class;
        $I->assertInstanceOf($class, $adapter);
    }
}