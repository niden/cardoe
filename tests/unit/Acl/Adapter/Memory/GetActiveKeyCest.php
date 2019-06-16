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
use Cardoe\Acl\Role;
use UnitTester;

class GetActiveKeyCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveKey()
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2017-01-13
     */
    public function aclAdapterMemoryGetActiveKey(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveKey()');

        $acl = new Memory();

        $acl->addRole(
            new Role('Guests')
        );

        $acl->addComponent(
            new Component('Post'),
            ['index', 'update', 'create']
        );

        $acl->allow('Guests', 'Post', 'create');

        $I->assertTrue(
            $acl->isAllowed('Guests', 'Post', 'create')
        );

        $I->assertEquals(
            'Guests!Post!create',
            $acl->getActiveKey()
        );
    }
}
