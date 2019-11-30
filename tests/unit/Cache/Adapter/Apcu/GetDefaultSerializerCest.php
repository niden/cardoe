<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);
namespace Cardoe\Test\Unit\Cache\Adapter\Apcu;

use UnitTester;

class GetDefaultSerializerCest
{
    /**
     * Unit Tests Cardoe\Cache\Adapter\Apcu :: getDefaultSerializer()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-05-25
     */
    public function cacheAdapterApcuGetDefaultSerializer(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Apcu - getDefaultSerializer()');

        $I->skipTest('Need implementation');
    }
}
