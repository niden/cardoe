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

class PathCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Php :: path()
     *
     * @since  2018-11-13
     */
    public function configAdapterPhpPath(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Php - path()');

        $this->checkPath($I, 'Php');
    }

    /**
     * Tests Cardoe\Config\Adapter\Php :: path() - default
     *
     * @since  2018-11-13
     */
    public function configAdapterPhpPathDefault(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Php - path() - default');

        $this->checkPathDefault($I, 'Php');
    }
}
