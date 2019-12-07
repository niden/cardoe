<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Arr;

use Cardoe\Helper\Arr;
use UnitTester;

class ValidateAnyCest
{
    /**
     * Tests Cardoe\Helper\Arr :: validateAny()
     *
     * @since  2019-04-07
     */
    public function helperArrValidateAny(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - validateAny()');
        $collection = [1, 2, 3, 4, 5];
        $actual     = Arr::validateAny(
            $collection,
            function ($element) {
                return $element < 2;
            }
        );
        $I->assertTrue($actual);
    }
}
