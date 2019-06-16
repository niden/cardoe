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

class GetRolesCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getRoles()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetRoles(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getRoles()');

        $acl = new Memory();

        $role1 = new Role('Admin');
        $role2 = new Role('Guest');

        $acl->addRole($role1);
        $acl->addRole($role2);

        $expected = [$role1, $role2];

        $I->assertEquals(
            $expected,
            $acl->getRoles()
        );
    }
}
