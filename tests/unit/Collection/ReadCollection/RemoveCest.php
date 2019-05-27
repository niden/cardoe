<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\Exception;
use Cardoe\Collection\ReadCollection;
use UnitTester;

class RemoveCest
{
    /**
     * Tests Cardoe\Collection :: remove()
     *
     * @since  2018-11-13
     */
    public function collectionRemove(UnitTester $I)
    {
        $I->wantToTest('Collection - remove()');

        $data       = [
            'one'   => 'two',
            'three' => 'four',
            'five'  => 'six',
        ];
        $collection = new ReadCollection($data);

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () use ($collection) {
                $collection->remove('five');
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () use ($collection) {
                $collection->remove('FIVE');
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () use ($collection) {
                unset($collection['five']);
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () use ($collection) {
                $collection->__unset('five');
            }
        );

        $I->expectThrowable(
            new Exception('The object is read only'),
            function () use ($collection) {
                $collection->offsetUnset('five');
            }
        );
    }
}
