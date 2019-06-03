<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Collection\Collection;

use Cardoe\Collection\Collection;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Collection\Collection :: __construct()
     *
     * @since  2018-11-13
     */
    public function collectionConstruct(UnitTester $I)
    {
        $I->wantToTest('Collection - __construct()');
        $collection = new Collection();

        $class = Collection::class;
        $I->assertInstanceOf($class, $collection);
    }
}
