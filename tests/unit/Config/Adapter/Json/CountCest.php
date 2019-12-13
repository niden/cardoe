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

class CountCest
{
    use ConfigTrait;

    public function _before(UnitTester $I)
    {
        $I->checkExtensionIsLoaded('json');
    }

    /**
     * Tests Cardoe\Config\Adapter\Json :: count()
     *
     * @since  2018-11-13
     */
    public function configAdapterJsonCount(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Json - count()');
        $this->checkCount($I, 'Json');
    }
}
