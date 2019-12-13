<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Json;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class OffsetGetCest
{
    use ConfigTrait;

    public function _before(UnitTester $I)
    {
        $I->checkExtensionIsLoaded('json');
    }

    /**
     * Tests Cardoe\Config\Adapter\Json :: offsetGet()
     *
     * @since  2018-11-13
     */
    public function configAdapterJsonOffsetGet(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Json - offsetGet()');
        $this->checkOffsetGet($I, 'Json');
    }
}
