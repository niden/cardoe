<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\Exception;
use Cardoe\Collection\ReadCollection;
use UnitTester;

class SetCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: set()
     *
     * @since  2018-11-13
     */
    public function collectionSet(UnitTester $I)
    {
        $I->wantToTest('Collection\ReadCollection - set()');

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () {
                $collection = new ReadCollection();
                $collection->set('three', 123);
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () {
                $collection        = new ReadCollection();
                $collection->three = 'Cardoe';
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () {
                $collection = new ReadCollection();
                $collection->offsetSet('three', 123);
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () {
                $collection          = new ReadCollection();
                $collection['three'] = true;
            }
        );
    }
}
