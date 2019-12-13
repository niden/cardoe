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

class SetPathDelimiterCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Ini :: setPathDelimiter()
     *
     * @since  2018-11-13
     */
    public function configAdapterIniSetPathDelimiter(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Ini - setPathDelimiter()');
        $this->checkSetPathDelimiter($I, 'Ini');
    }
}
