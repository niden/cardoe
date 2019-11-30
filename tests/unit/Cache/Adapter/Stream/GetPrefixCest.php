<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Stream;

use Cardoe\Cache\Adapter\Stream;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function outputDir;

class GetPrefixCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - getPrefix()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream(
            $serializer,
            [
                'storageDir' => outputDir(),
                'prefix'     => 'my-prefix',
            ]
        );

        $expected = 'my-prefix';
        $actual   = $adapter->getPrefix();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Cache\Adapter\Stream :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-24
     */
    public function cacheAdapterStreamGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $expected = 'phstrm-';
        $actual   = $adapter->getPrefix();
        $I->assertEquals($expected, $actual);
    }
}
