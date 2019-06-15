<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Helper\Number;

use Cardoe\Helper\Number;
use Cardoe\Helper\Obj;
use stdClass;
use UnitTester;

class CloneInstanceCest
{
    /**
     * Tests Cardoe\Helper\Number :: between()
     *
     * @since  2019-06-15
     */
    public function helperObjCloneInstance(UnitTester $I)
    {
        $I->wantToTest('Helper\Obj - cloneInstance()');

        $instance = new stdClass();
        $instance->one = 'two';
        $instance->two = 'three';

        $newInstance = Obj::cloneInstance($instance, 'four', 'one');

        $I->assertNotSame($instance, $newInstance);

        $I->assertEquals('two', $instance->one);
        $I->assertEquals('four', $newInstance->one);
    }
}
