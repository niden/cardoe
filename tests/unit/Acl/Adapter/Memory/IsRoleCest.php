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
use Cardoe\Acl\Role;
use UnitTester;

class IsRoleCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isRole()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryIsRole(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isRole()');

        $acl     = new Memory();
        $aclRole = new Role('Administrators', 'Super User access');

        $acl->addRole($aclRole);

        $I->assertTrue(
            $acl->isRole('Administrators')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isRole() - unknown
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryIsRoleUnknown(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isRole() - unknown');

        $acl     = new Memory();
        $aclRole = new Role('Administrators', 'Super User access');

        $acl->addRole($aclRole);

        $I->assertFalse(
            $acl->isRole('unknown')
        );
    }
}
