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
use Cardoe\Acl\Exception;
use Cardoe\Acl\Role;
use UnitTester;

class AddRoleCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - string
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleString(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - string');

        $acl = new Memory();

        $role = new Role('Administrators', 'Super User access');

        $I->assertTrue(
            $acl->addRole('Administrators')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - object
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleObject(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - object');

        $acl = new Memory();

        $role = new Role('Administrators', 'Super User access');

        $I->assertTrue(
            $acl->addRole($role)
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - twice string
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleTwiceString(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - twice string');

        $acl = new Memory();

        $role = new Role('Administrators', 'Super User access');

        $I->assertTrue(
            $acl->addRole('Administrators')
        );

        $I->assertFalse(
            $acl->addRole('Administrators')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - twice object
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleTwiceObject(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - twice object');

        $acl = new Memory();

        $role = new Role('Administrators', 'Super User access');

        $I->assertTrue(
            $acl->addRole($role)
        );

        $I->assertFalse(
            $acl->addRole($role)
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - numeric key
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleNumericKey(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - numeric key');

        $acl = new Memory();

        $role = new Role('11', 'Super User access');

        $I->assertTrue(
            $acl->addRole('11')
        );

        $I->assertTrue(
            $acl->isRole('11')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addRole() - exception
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddRoleException(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addRole() - numeric key');

        $I->expectThrowable(
            new Exception(
                'Role must be either a string or implement RoleInterface'
            ),
            function () {
                $acl = new Memory();
                $acl->addRole(true);
            }
        );
    }
}
