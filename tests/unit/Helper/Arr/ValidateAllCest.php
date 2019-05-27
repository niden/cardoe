<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use UnitTester;

class ValidateAllCest
{
    /**
     * Tests Cardoe\Helper\Arr :: validateAll()
     *
     * @since  2019-04-07
     */
    public function helperArrValidateAll(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - validateAll()');
        $collection = [2, 3, 4, 5];
        $actual     = Arr::validateAll(
            $collection,
            function ($element) {
                return $element > 1;
            }
        );
        $I->assertTrue($actual);
    }
}
