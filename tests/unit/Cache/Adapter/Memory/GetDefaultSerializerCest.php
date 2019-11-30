<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use UnitTester;

class GetDefaultSerializerCest
{
    /**
     * Unit Tests Cardoe\Cache\Adapter\Memory :: getDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-25
     */
    public function cacheAdapterMemoryGetDefaultSerializer(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Memory - getDefaultSerializer()');

        $I->skipTest('Need implementation');
    }
}
