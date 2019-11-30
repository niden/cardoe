<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Stream;

use Cardoe\Storage\Adapter\AdapterInterface;
use Cardoe\Storage\Adapter\Stream;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use UnitTester;

use function outputDir;

class ConstructCest
{
    /**
     * Tests Cardoe\Storage\Adapter\Stream :: __construct()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamConstruct(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - __construct()');

        $serializer = new SerializerFactory();

        $adapter = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
            ]
        );

        $I->assertInstanceOf(
            Stream::class,
            $adapter
        );

        $I->assertInstanceOf(
            AdapterInterface::class,
            $adapter
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Stream :: __construct() - exception
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function storageAdapterStreamConstructException(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Stream - __construct() - exception');

        $I->expectThrowable(
            new Exception("The 'storageDir' must be specified in the options"),
            function () {
                $serializer = new SerializerFactory();
                $adapter    = new Stream($serializer);
            }
        );
    }
}
