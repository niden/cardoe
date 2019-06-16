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

class ToStringCest
{
    /**
     * Tests Cardoe\Acl\Role :: __toString()
     *
     * @since  2018-11-13
     */
    public function aclRoleToString(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - __toString()');

        $role = new Role('Administrator');

        $I->assertEquals(
            'Administrator',
            $role->__toString()
        );

        $I->assertEquals(
            'Administrator',
            (string) $role
        );
    }
}
