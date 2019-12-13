<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Grouped;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class PathCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Grouped :: path()
     *
     * @since  2018-11-13
     */
    public function configAdapterGroupedPath(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Grouped - path()');

        $config = $this->getConfig('Grouped');

        $I->assertCount(
            2,
            $config->path('test')
        );


        $I->assertEquals(
            'something-else',
            $config->path('test.property2')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\Grouped :: path() - default
     *
     * @since  2018-11-13
     */
    public function configAdapterGroupedPathDefault(UnitTester $I)
    {
        $this->checkPathDefault($I, 'Grouped');
    }
}
