<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use UnitTester;

class DecapitalizeCest
{
    /**
     * Tests Cardoe\Helper\Str :: decapitalize()
     *
     * @since  2019-04-06
     */
    public function helperStrDecapitalize(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - decapitalize()');

        $source   = 'BeetleJuice';
        $expected = 'beetleJuice';
        $actual   = Str::decapitalize($source);
        $I->assertEquals($expected, $actual);

        $source   = 'BeetleJuice';
        $expected = 'bEETLEJUICE';
        $actual   = Str::decapitalize($source, true);
        $I->assertEquals($expected, $actual);
    }
}
