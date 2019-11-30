<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Collection\ReadCollection;

use Cardoe\Collection\ReadCollection;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Collection\ReadCollection :: __construct()
     *
     * @since  2018-11-13
     */
    public function collectionConstruct(UnitTester $I)
    {
        $I->wantToTest('Collection\ReadCollection - __construct()');
        $collection = new ReadCollection();

        $class = ReadCollection::class;
        $I->assertInstanceOf($class, $collection);
    }
}
