<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\Collection;

use UnitTester;

class UnderscoreUnsetCest
{
    /**
     * Unit Tests Cardoe\Collection :: __unset()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-05-25
     */
    public function collectionUnderscoreUnset(UnitTester $I)
    {
        $I->wantToTest('Collection - __unset()');

        $I->skipTest('Need implementation');
    }
}
