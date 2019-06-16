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

class GetActiveRoleCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveRole() - default
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetActiveRoleDefault(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveRole() - default');

        $acl = new Memory();

        $I->assertNull(
            $acl->getActiveRole()
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveRole() - default
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetActiveRole(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveRole()');

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
            'Guests',
            $acl->getActiveRole()
        );
    }
}
