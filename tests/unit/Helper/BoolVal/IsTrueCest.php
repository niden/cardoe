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

class IsTrueCest
{
    /**
     * Tests Phalcon\Helper\BoolVal :: isTrue()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-03-10
     */
    public function helperBoolValIsTrue(UnitTester $I)
    {
        $I->wantToTest('Helper\BoolVal - isTrue()');

        $I->assertTrue(BoolVal::isTrue('1'));
        $I->assertTrue(BoolVal::isTrue('t'));
        $I->assertTrue(BoolVal::isTrue('true'));
        $I->assertTrue(BoolVal::isTrue('y'));
        $I->assertTrue(BoolVal::isTrue('yes'));
        $I->assertTrue(BoolVal::isTrue(1));
        $I->assertTrue(BoolVal::isTrue('T'));
        $I->assertTrue(BoolVal::isTrue('TRUE'));
        $I->assertTrue(BoolVal::isTrue('Y'));
        $I->assertTrue(BoolVal::isTrue('YES'));
    }
}
