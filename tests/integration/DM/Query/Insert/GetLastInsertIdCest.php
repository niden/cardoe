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

namespace Phalcon\Test\Unit\DM\Query\Insert;

use UnitTester;

class GetLastInsertIdCest
{
    /**
     * Unit Tests Phalcon\DM\Query\Insert :: getLastInsertId()
     *
     * @since  2020-01-20
     */
    public function dMQueryInsertGetLastInsertId(UnitTester $I)
    {
        $I->wantToTest('DM\Query\Insert - getLastInsertId()');

        $I->skipTest('Need implementation');
    }
}
