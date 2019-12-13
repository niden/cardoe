<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Php;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class OffsetUnsetCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Php :: offsetUnset()
     *
     * @since  2018-11-13
     */
    public function configAdapterPhpOffsetUnset(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Php - offsetUnset()');
        $this->checkOffsetUnset($I, 'Php');
    }
}
