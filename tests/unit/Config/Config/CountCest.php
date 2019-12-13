<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Config;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class CountCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Config :: count()
     *
     * @since  2019-06-19
     */
    public function configCount(UnitTester $I)
    {
        $I->wantToTest('Config - count()');
        $this->checkCount($I);
    }
}
