<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Role;

use Cardoe\Acl\Role;
use UnitTester;

class GetDescriptionCest
{
    /**
     * Tests Cardoe\Acl\Role :: getDescription()
     *
     * @since  2018-11-13
     */
    public function aclRoleGetDescription(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - getDescription()');

        $role = new Role('Administrators', 'The admin unit');

        $I->assertEquals(
            'The admin unit',
            $role->getDescription()
        );
    }

    /**
     * Tests Cardoe\Acl\Role :: getDescription() - empty
     *
     * @since  2018-11-13
     */
    public function aclRoleGetDescriptionEmpty(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - getDescription()');

        $role = new Role('Administrators');

        $I->assertEmpty(
            $role->getDescription()
        );
    }
}
