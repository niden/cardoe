<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\Adapter\Noop;

use Cardoe\Logger\Adapter\Noop;
use Cardoe\Logger\Item;
use Cardoe\Logger\Logger;
use UnitTester;

class AddCest
{
    /**
     * Tests Cardoe\Logger\Adapter\Noop :: add()
     *
     * @since  2018-11-13
     */
    public function loggerAdapterNoopAdd(UnitTester $I)
    {
        $I->wantToTest('Logger\Adapter\Noop - add()');

        $adapter = new Noop();

        $adapter->begin();

        $item1 = new Item(
            'Message 1',
            'debug',
            Logger::DEBUG
        );

        $item2 = new Item(
            'Message 2',
            'debug',
            Logger::DEBUG
        );

        $item3 = new Item(
            'Message 3',
            'debug',
            Logger::DEBUG
        );

        $adapter
            ->add($item1)
            ->add($item2)
            ->add($item3)
        ;

        $adapter->commit();
    }
}
