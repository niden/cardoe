<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Apcu;

use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class GetAdapterCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: getAdapter()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-14
     */
    public function storageAdapterApcuGetAdapter(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - getAdapter()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $actual = $adapter->getAdapter();
        $I->assertNull($actual);
    }
}
