<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Helper\Json;

use Phalcon\Helper\BoolVal;
use UnitTester;

class IsFalseCest
{
    /**
     * Tests Phalcon\Helper\BoolVal :: isFalse()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-03-10
     */
    public function helperBoolValIsFalse(UnitTester $I)
    {
        $I->wantToTest('Helper\BoolVal - isFalse()');

        $I->assertTrue(BoolVal::isFalse('0'));
        $I->assertTrue(BoolVal::isFalse('f'));
        $I->assertTrue(BoolVal::isFalse('false'));
        $I->assertTrue(BoolVal::isFalse('n'));
        $I->assertTrue(BoolVal::isFalse('no'));
        $I->assertTrue(BoolVal::isFalse(0));
        $I->assertTrue(BoolVal::isFalse('F'));
        $I->assertTrue(BoolVal::isFalse('FALSE'));
        $I->assertTrue(BoolVal::isFalse('N'));
        $I->assertTrue(BoolVal::isFalse('NO'));
    }
}
