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

class GetPathDelimiterCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Grouped :: getPathDelimiter()
     *
     * @since  2018-11-13
     */
    public function configAdapterGroupedGetPathDelimiter(UnitTester $I)
    {
        $this->checkGetPathDelimiter($I, 'Grouped');
    }
}
