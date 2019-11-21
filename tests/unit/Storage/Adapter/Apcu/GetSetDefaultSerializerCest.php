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

use Cardoe\Storage\Adapter\Apcu;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\ApcuTrait;
use UnitTester;

class GetSetDefaultSerializerCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu ::
     * getDefaultSerializer()/setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterApcuGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - getDefaultSerializer()/setDefaultSerializer()');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $I->assertEquals('Php', $adapter->getDefaultSerializer());

        $adapter->setDefaultSerializer('Base64');
        $I->assertEquals('Base64', $adapter->getDefaultSerializer());
    }
}
