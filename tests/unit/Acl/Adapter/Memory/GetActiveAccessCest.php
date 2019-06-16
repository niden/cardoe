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

class GetActiveAccessCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveAccess() - default
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetActiveAccessDefault(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveAccess() - default');

        $acl = new Memory();

        $I->assertNull(
            $acl->getActiveAccess()
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveAccess() - default
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetActiveAccess(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveAccess()');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $acl->addRole('Guests');

        $acl->addComponent(
            'Login',
            ['help', 'index']
        );

        $acl->allow('Guests', 'Login', '*');

        $I->assertTrue(
            $acl->isAllowed('Guests', 'Login', 'index')
        );

        $I->assertEquals(
            'index',
            $acl->getActiveAccess()
        );
    }
}
