<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Config;

use Cardoe\Config\Config;
use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class OffsetGetCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Config :: offsetGet()
     *
     * @since  2019-06-19
     */
    public function configOffsetGet(UnitTester $I)
    {
        $I->wantToTest('Config\Config - offsetGet()');

        $this->checkOffsetGet($I);
    }

    /**
     * Tests access by numeric key
     *
     * @author Rian Orie <rian.orie@gmail.com>
     * @since  2014-11-12
     */
    public function testNumericConfig(UnitTester $I)
    {
        $config = new Config(
            [
                'abc',
            ]
        );

        $I->assertEquals(
            'abc',
            $config->{0}
        );
    }
}
