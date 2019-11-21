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

class GetPrefixCest
{
    use ApcuTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Apcu :: getPrefix()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuGetSetPrefix(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - getPrefix()');

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
     * Tests Cardoe\Storage\Adapter\Apcu :: getPrefix() - default
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-03-31
     */
    public function storageAdapterApcuGetSetPrefixDefault(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Apcu - getPrefix() - default');

        $serializer = new SerializerFactory();
        $adapter    = new Apcu($serializer);

        $I->assertEquals(
            'ph-apcu-',
            $adapter->getPrefix()
        );
    }
}
