<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use Cardoe\Acl;
use Cardoe\Acl\Adapter\Memory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: __construct() - constants
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryConstructConstants(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - __construct() - constants');

        $I->assertEquals(1, Memory::ALLOW);
        $I->assertEquals(0, Memory::DENY);
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: __construct()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - __construct()');

        $acl = new Memory();

        $I->assertInstanceOf(
            Memory::class,
            $acl
        );
    }
}
