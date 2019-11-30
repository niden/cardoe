<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Libmemcached;

use UnitTester;

class SetDefaultSerializerCest
{
    /**
     * Unit Tests Cardoe\Cache\Adapter\Libmemcached :: setDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-25
     */
    public function cacheAdapterLibmemcachedSetDefaultSerializer(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Libmemcached - setDefaultSerializer()');

        $I->skipTest('Need implementation');
    }
}
