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

class DenyCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: deny()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryDeny(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - deny()');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::ALLOW
        );

        $acl->addRole('Guests');
        $acl->addRole('Member');

        $acl->addComponent(
            'Post',
            ['update']
        );

        $acl->deny('Member', 'Post', 'update');

        $I->assertTrue(
            $acl->isAllowed('Guest', 'Post', 'update')
        );

        $I->assertFalse(
            $acl->isAllowed('Member', 'Post', 'update')
        );
    }
}
