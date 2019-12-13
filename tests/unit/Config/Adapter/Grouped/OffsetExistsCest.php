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

class OffsetExistsCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Grouped :: offsetExists()
     *
     * @since  2018-11-13
     */
    public function configAdapterGroupedOffsetExists(UnitTester $I)
    {
        $this->checkOffsetExists($I, 'Grouped');
    }
}
