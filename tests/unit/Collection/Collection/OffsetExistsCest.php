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

class OffsetExistsCest
{
    /**
     * Unit Tests Cardoe\Collection :: offsetExists()
     *
     * @author Cardoe Team <team@phalconphp.com>
     * @since  2019-05-25
     */
    public function collectionOffsetExists(UnitTester $I)
    {
        $I->wantToTest('Collection - offsetExists()');

        $I->skipTest('Need implementation');
    }
}
