<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use Cardoe\Acl\Adapter\Memory;
use Cardoe\Acl\Component;
use UnitTester;

class IsComponentCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isComponent()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryIsComponent(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isComponent()');

        $acl          = new Memory();
        $aclComponent = new Component('Customers', 'Customer management');

        $acl->addComponent($aclComponent, 'search');

        $I->assertTrue(
            $acl->isComponent('Customers')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isComponent() - unknown
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryIsComponentUnknown(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isComponent() - unknown');

        $acl          = new Memory();
        $aclComponent = new Component('Customers', 'Customer management');

        $acl->addComponent($aclComponent, 'search');

        $I->assertFalse(
            $acl->isComponent('unknown')
        );
    }
}
