<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use Exception;
use Cardoe\Acl\Exception as AclException;
use Cardoe\Acl\Adapter\Memory;
use Cardoe\Test\Fixtures\Acl\TestComponentAware;
use Cardoe\Test\Fixtures\Acl\TestRoleAware;
use UnitTester;

class AllowCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: allow()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAllow(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - allow()');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::DENY
        );

        $acl->addRole('Guests');
        $acl->addRole('Member');

        $acl->addComponent(
            'Post',
            ['update']
        );

        $acl->allow('Member', 'Post', 'update');

        $I->assertFalse(
            $acl->isAllowed('Guest', 'Post', 'update')
        );

        $I->assertFalse(
            $acl->isAllowed('Guest', 'Post', 'update')
        );

        $I->assertTrue(
            $acl->isAllowed('Member', 'Post', 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: allow() - wildcard
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAllowWildcard(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - allow() - wildcard');

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addRole('Member');
        $acl->addComponent('Post', ['update']);

        $acl->allow('Member', 'Post', '*');
        $I->assertTrue(
            $acl->isAllowed('Member', 'Post', 'update')
        );

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addRole('Member');
        $acl->addComponent('Post', ['update']);

        $acl->allow('Member', '*', '*');
        $I->assertTrue(
            $acl->isAllowed('Member', 'Post', 'update')
        );

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addRole('Member');
        $acl->addRole('Guest');
        $acl->addInherit('Guest', 'Member');
        $acl->addComponent('Post', ['update']);

        $acl->allow('Member', '*', '*');
        $I->assertTrue(
            $acl->isAllowed('Guest', 'Post', 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: allow() - exception
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAllowException(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - allow() - exception');

        $I->expectThrowable(
            new AclException(
                "Role 'Unknown' does not exist in the ACL"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Unknown', 'Post', 'update');
            }
        );

        $I->expectThrowable(
            new AclException(
                "Component 'Unknown' does not exist in the ACL"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Member', 'Unknown', 'update');
            }
        );

        $I->expectThrowable(
            new AclException(
                "Access 'Unknown' does not exist in component 'Post'"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Member', 'Post', 'Unknown');
            }
        );

        $I->expectThrowable(
            new AclException(
                "Access 'Unknown' does not exist in component 'Post'"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addRole('Member');
                $acl->addComponent('Post', ['update']);
                $acl->allow('Member', 'Post', ['Unknown']);
            }
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: allow() - function
     *
     * @issue   https://github.com/phalcon/cphalcon/issues/11235
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2015-12-16
     */
    public function aclAdapterMemoryAllowFunction(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - allow() - function');

        $acl = new Memory();

        $acl->setDefaultAction(Memory::DENY);

        $acl->addRole('Guests');
        $acl->addRole('Members', 'Guests');
        $acl->addRole('Admins', 'Members');

        $acl->addComponent(
            'Post',
            ['update']
        );

        $guest         = new TestRoleAware(1, 'Guests');
        $member        = new TestRoleAware(2, 'Members');
        $anotherMember = new TestRoleAware(3, 'Members');
        $admin         = new TestRoleAware(4, 'Admins');
        $model         = new TestComponentAware(2, 'Post');

        $acl->deny('Guests', 'Post', 'update');

        $acl->allow(
            'Members',
            'Post',
            'update',
            function (TestRoleAware $user, TestComponentAware $model) {
                return $user->getId() == $model->getUser();
            }
        );

        $acl->allow('Admins', 'Post', 'update');

        $I->assertFalse(
            $acl->isAllowed($guest, $model, 'update')
        );

        $I->assertTrue(
            $acl->isAllowed($member, $model, 'update')
        );


        $I->assertFalse(
            $acl->isAllowed($anotherMember, $model, 'update')
        );

        $I->assertTrue(
            $acl->isAllowed($admin, $model, 'update')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: allow() - function exception
     *
     * @issue   https://github.com/phalcon/cphalcon/issues/11235
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2016-06-05
     */
    public function aclAdapterMemoryAllowFunctionException(UnitTester $I)
    {
        $I->expectThrowable(
            new Exception(
                "You didn't provide any parameters when 'Guests' can " .
                "'update' 'Post'. We will use default action when no arguments.",
                1024
            ),
            function () use ($I) {
                $acl = new Memory();

                $acl->setDefaultAction(
                    Memory::ALLOW
                );

                $acl->setNoArgumentsDefaultAction(
                    Memory::DENY
                );

                $acl->addRole('Guests');
                $acl->addRole('Members', 'Guests');
                $acl->addRole('Admins', 'Members');
                $acl->addComponent('Post', ['update']);

                $guest         = new TestRoleAware(1, 'Guests');
                $member        = new TestRoleAware(2, 'Members');
                $anotherMember = new TestRoleAware(3, 'Members');
                $admin         = new TestRoleAware(4, 'Admins');
                $model         = new TestComponentAware(2, 'Post');

                $acl->allow(
                    'Guests',
                    'Post',
                    'update',
                    function ($parameter) {
                        return $parameter % 2 == 0;
                    }
                );

                $acl->allow(
                    'Members',
                    'Post',
                    'update',
                    function ($parameter) {
                        return $parameter % 2 == 0;
                    }
                );

                $acl->allow('Admins', 'Post', 'update');

                $I->assertFalse(
                    $acl->isAllowed($guest, $model, 'update')
                );

                $I->assertFalse(
                    $acl->isAllowed($member, $model, 'update')
                );

                $I->assertFalse(
                    $acl->isAllowed($anotherMember, $model, 'update')
                );

                $I->assertTrue(
                    $acl->isAllowed($admin, $model, 'update')
                );
            }
        );
    }
}
