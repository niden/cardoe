<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Ini;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class GetCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Ini :: get()
     *
     * @since  2018-11-13
     */
    public function configAdapterIniGet(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Ini - get()');
        $this->checkGet($I, 'Ini');
    }
}