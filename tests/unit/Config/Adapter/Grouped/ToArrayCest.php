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

class ToArrayCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Grouped :: toArray()
     *
     * @author kjdev
     * @since  2013-07-18
     */
    public function configAdapterGroupedToArray(UnitTester $I)
    {
        $config = $this->getConfig('Grouped');

        $options                      = $this->config;
        $options['test']['property2'] = 'something-else';

        $I->assertEquals(
            $options,
            $config->toArray()
        );
    }
}
