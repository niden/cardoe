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

class GetCest
{
    /**
     * Tests Cardoe\Helper\Arr :: get() - numeric
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-02-17
     */
    public function helperArrGetNumeric(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - numeric');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Cardoe',
            Arr::get($collection, 1, 'Error')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - string
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-02-17
     */
    public function helperArrGetString(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - string');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Framework',
            Arr::get($collection, 'suffix', 'Error')
        );
    }

    /**
     * Tests Cardoe\Helper\Arr :: get() - default
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-02-17
     */
    public function helperArrGetDefault(UnitTester $I)
    {
        $I->wantToTest('Helper\Arr - get() - default');

        $collection = [
            1        => 'Cardoe',
            'suffix' => 'Framework',
        ];

        $I->assertEquals(
            'Error',
            Arr::get($collection, 'unknown', 'Error')
        );
    }
}
