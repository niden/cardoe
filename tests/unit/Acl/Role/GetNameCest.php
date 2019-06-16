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

class GetNameCest
{
    /**
     * Tests Cardoe\Acl\Role :: getName()
     *
     * @since  2018-11-13
     */
    public function aclRoleGetName(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - getName()');

        $role = new Role('Administrators');

        $I->assertEquals(
            'Administrators',
            $role->getName()
        );
    }
}
