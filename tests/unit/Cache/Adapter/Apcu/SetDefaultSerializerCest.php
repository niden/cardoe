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

use UnitTester;

class SetDefaultSerializerCest
{
    /**
     * Unit Tests Cardoe\Cache\Adapter\Apcu :: setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-25
     */
    public function cacheAdapterApcuSetDefaultSerializer(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - setDefaultSerializer()');

        $I->skipTest('Need implementation');
    }
}
