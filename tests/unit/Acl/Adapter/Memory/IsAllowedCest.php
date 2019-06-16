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
use Cardoe\Acl\Component;
use Cardoe\Acl\Exception as AclException;
use Cardoe\Acl\Role;
use Cardoe\Test\Fixtures\Acl\TestComponentAware;
use Cardoe\Test\Fixtures\Acl\TestRoleAware;
use Cardoe\Test\Fixtures\Acl\TestRoleComponentAware;
use Exception;
use stdClass;
use UnitTester;

class IsAllowedCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - default
     *
     * @issue   https://github.com/phalcon/cphalcon/issues/12573
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2017-01-25
     */
    public function aclAdapterMemoryIsAllowedDefault(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - default');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $acl->addComponent(
            new Component('Post'),
            [
                'index',
                'update',
                'create',
            ]
        );

        $acl->addRole(
            new Role('Guests')
        );

        $acl->allow('Guests', 'Post', 'index');

        $I->assertTrue(
            $acl->isAllowed('Guests', 'Post', 'index')
        );

        $I->assertFalse(
            $acl->isAllowed('Guests', 'Post', 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - objects
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2017-02-15
     */
    public function aclAdapterMemoryIsAllowedObjects(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - objects');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $role = new Role('Guests');

        $component = new Component('Post');

        $acl->addRole($role);

        $acl->addComponent(
            $component,
            [
                'index',
                'update',
                'create',
            ]
        );

        $acl->allow('Guests', 'Post', 'index');

        $I->assertTrue(
            $acl->isAllowed($role, $component, 'index')
        );

        $I->assertFalse(
            $acl->isAllowed($role, $component, 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - same class
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2017-02-15
     */
    public function aclAdapterMemoryIsAllowedSameClass(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - same class');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $role      = new TestRoleComponentAware(1, 'User', 'Admin');
        $component = new TestRoleComponentAware(2, 'User', 'Admin');

        $acl->addRole('Admin');

        $acl->addComponent(
            'User',
            ['update']
        );

        $acl->allow(
            'Admin',
            'User',
            ['update'],
            function (TestRoleComponentAware $admin, TestRoleComponentAware $user) {
                return $admin->getUser() == $user->getUser();
            }
        );

        $I->assertFalse(
            $acl->isAllowed($role, $component, 'update')
        );

        $I->assertTrue(
            $acl->isAllowed($role, $role, 'update')
        );

        $I->assertTrue(
            $acl->isAllowed($component, $component, 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - function no parameters
     *
     * @since   2019-06-16
     */
    public function aclAdapterMemoryIsAllowedFunctionNoParameters(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - no parameters');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $acl->addRole('Admin');
        $acl->addComponent('User', ['update']);
        $acl->allow(
            'Admin',
            'User',
            ['update'],
            function () {
                return true;
            }
        );

        $I->assertTrue(
            $acl->isAllowed('Admin', 'User', 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - function more parameters
     *
     * @since   2019-06-16
     */
    public function aclAdapterMemoryIsAllowedFunctionMoreParameters(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - more parameters');

        $I->expectThrowable(
            new Exception(
                "Number of parameters in array is higher than the " .
                "number of parameters in defined function when checking if " .
                "'Members' can 'update' 'Post'. Extra parameters will be ignored.",
                512
            ),
            function () use ($I) {
                $acl = new Memory();

                $acl->setDefaultAction(Memory::ALLOW);
                $acl->setNoArgumentsDefaultAction(Memory::DENY);

                $acl->addRole('Members');
                $acl->addComponent('Post', ['update']);

                $member = new TestRoleAware(2, 'Members');
                $model  = new TestComponentAware(2, 'Post');

                $acl->allow(
                    'Members',
                    'Post',
                    'update',
                    function ($parameter) {
                        return $parameter % 2 == 0;
                    }
                );

                $acl->isAllowed(
                    $member,
                    $model,
                    'update',
                    [
                        'parameter' => 1,
                        'one'       => 2,
                    ]
                );
            }
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - function not enough parameters
     *
     * @since   2019-06-16
     */
    public function aclAdapterMemoryIsAllowedFunctionNotEnoughParameters(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - more parameters');

        $I->expectThrowable(
            new AclException(
                "You did not provide all necessary parameters for the " .
                "defined function when checking if 'Members' can 'update' for 'Post'."
            ),
            function () use ($I) {
                $acl = new Memory();

                $acl->setDefaultAction(Memory::ALLOW);
                $acl->setNoArgumentsDefaultAction(Memory::DENY);

                $acl->addRole('Members');
                $acl->addComponent('Post', ['update']);

                $member = new TestRoleAware(2, 'Members');
                $model  = new TestComponentAware(2, 'Post');

                $acl->allow(
                    'Members',
                    'Post',
                    'update',
                    function ($parameter, $value) {
                        return $parameter % $value == 0;
                    }
                );

                $acl->isAllowed(
                    $member,
                    $model,
                    'update',
                    [
                        'parameter' => 1,
                        'one'       => 2,
                    ]
                );
            }
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: isAllowed() - exception
     *
     * @since   2019-06-16
     */
    public function aclAdapterMemoryIsAllowedException(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - isAllowed() - exception');

        $I->expectThrowable(
            new AclException(
                "Object passed as roleName must implement " .
                "Cardoe\\Acl\\RoleAware or Cardoe\\Acl\\RoleInterface"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Member', 'Post', 'update');
                $acl->isAllowed(new stdClass(), 'Post', 'update');
            }
        );

        $I->expectThrowable(
            new AclException(
                "Object passed as componentName must implement " .
                "Cardoe\\Acl\\ComponentAware or Cardoe\\Acl\\ComponentInterface"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Member', 'Post', 'update');
                $acl->isAllowed('Member', new stdClass(), 'update');
            }
        );
    }
}
