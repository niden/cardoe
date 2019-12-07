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

use function outputDir;

class GetSetDefaultSerializerCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream ::
     * getDefaultSerializer()/setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterStreamGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - getDefaultSerializer()/setDefaultSerializer()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
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
