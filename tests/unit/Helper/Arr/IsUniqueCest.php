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

class IsUniqueCest
{
    /**
     * Tests Cardoe\Helper\Arr :: isUnique()
     *
     * @since  2019-04-06
     */
    public function helperArrIsUnique(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - isUnique()');


        $collection = [
            'Cardoe',
            'Framework',
        ];

        $I->assertTrue(
            Arr::isUnique($collection)
        );


        $collection = [
            'Cardoe',
            'Framework',
            'Cardoe',
        ];

        $I->assertFalse(
            Arr::isUnique($collection)
        );
    }
}
