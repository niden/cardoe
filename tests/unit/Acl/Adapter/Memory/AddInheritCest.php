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

class AddInheritCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit()
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAddInherit(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addInherit()');

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addComponent('widget', 'read');
        $acl->addRole('A');
        $acl->addRole('B');
        $acl->addRole('C');
        $acl->addInherit('B', 'C');
        $acl->addInherit('A', 'B');
        $acl->allow('C', 'widget', 'read');

        $I->assertTrue(
            $acl->isAllowed(
                'A',
                'widget',
                'read'
            )
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit() - exception
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAddInheritException(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addInherit() - exception');

        $I->expectThrowable(
            new Exception(
                "Role 'Unknown' does not exist in the role list"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addComponent('widget', 'read');
                $acl->addRole('A');
                $acl->addInherit('Unknown', 'A');
            }
        );

        $I->expectThrowable(
            new Exception(
                "Role 'Unknown' (to inherit) does not exist in the role list"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addComponent('widget', 'read');
                $acl->addRole('A');
                $acl->addInherit('A', 'Unknown');
            }
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit() - same role
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAddInheritSameRole(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addInherit() - same role');

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addComponent('widget', 'read');
        $acl->addRole('A');
        $I->assertFalse(
            $acl->addInherit('A', 'A')
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit() - reverse
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAddInheritReverse(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addInherit() - reverse');

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);
        $acl->addComponent('widget', 'read');
        $acl->addRole('A');
        $acl->addRole('B');
        $acl->addRole('C');
        $acl->addInherit('A', 'B');
        $acl->addInherit('B', 'C');
        $acl->allow('C', 'widget', 'read');

        $I->assertTrue(
            $acl->isAllowed(
                'A',
                'widget',
                'read'
            )
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit() - deep inheritance order
     * objects
     *
     * @since  2019-06-16
     * @issue https://github.com/phalcon/cphalcon/issues/10294
     */
    public function aclAdapterMemoryAddInheritDeepInheritanceOrderObjects(UnitTester $I)
    {
        $I->wantToTest(
            'Acl\Adapter\Memory - addInherit() - deep inheritance order objects'
        );

        $acl = new Memory();
        $acl->setDefaultAction(Memory::DENY);

        $acl->addRole(new Role('Jane'));
        $acl->addRole(new Role('Admin'));
        $acl->addRole(new Role('User'));
        $acl->addComponent(
            'Contact',
            ['ping', 'info', 'getAll']
        );

        $acl->allow('Admin', 'Contact', 'ping');
        $acl->allow('User', 'Contact', 'getAll');
        $acl->allow('Jane', 'Contact', 'info');

        $acl->addInherit('Jane', 'Admin');
        $acl->addInherit('Admin', 'User');

        $I->assertTrue(
            $acl->isAllowed(
                'Jane',
                'Contact',
                'ping'
            )
        );
        $I->assertTrue(
            $acl->isAllowed(
                'Jane',
                'Contact',
                'getAll'
            )
        );
        $I->assertTrue(
            $acl->isAllowed(
                'Jane',
                'Contact',
                'info'
            )
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addInherit() - infinite loop
     * objects
     *
     * @since  2019-06-16
     */
    public function aclAdapterMemoryAddInheritInfiniteLoop(UnitTester $I)
    {
        $I->wantToTest(
            'Acl\Adapter\Memory - addInherit() - infinite loop'
        );

        $I->expectThrowable(
            new Exception(
                "Role 'A' (to inherit) produces an infinite loop"
            ),
            function () {
                $acl = new Memory();
                $acl->setDefaultAction(Memory::DENY);
                $acl->addComponent('widget', 'read');
                $acl->addRole('A');
                $acl->addRole('B');
                $acl->addInherit('A', 'B');
                $acl->addInherit('B', 'A');
                $acl->allow('C', 'widget', 'read');

                $acl->isAllowed(
                    'A',
                    'widget',
                    'read'
                );
            }
        );
    }
}
