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

class GetPrefixCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterApcuGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - getPrefix()');

        $serializer = new SerializerFactory();

        $adapter = new Apcu(
            $serializer,
            [
                'prefix' => 'my-prefix',
            ]
        );

        $I->assertEquals(
            'my-prefix',
            $adapter->getPrefix()
        );
    }

    /**
     * Tests Cardoe\Cache\Adapter\Apcu :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function cacheAdapterApcuGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $I->assertEquals(
            'ph-apcu-',
            $adapter->getPrefix()
        );
    }
}
