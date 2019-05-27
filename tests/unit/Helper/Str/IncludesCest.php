<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Str;

use Cardoe\Helper\Str;
use UnitTester;

class IncludesCest
{
    /**
     * Tests Cardoe\Helper\Str :: includes()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-04-06
     */
    public function helperStrIncludes(UnitTester $I)
    {
        $I->wantToTest('Helper\Str - includes()');

        $source = 'Mary had a little lamb';
        $actual = Str::includes($source, 'lamb');
        $I->assertTrue($actual);

        $actual = Str::includes($source, 'unknown');
        $I->assertFalse($actual);
    }
}
