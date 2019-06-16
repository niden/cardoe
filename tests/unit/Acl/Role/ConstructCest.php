<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Role;

use BadMethodCallException;
use Cardoe\Acl\Exception;
use Cardoe\Acl\Role;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Acl\Role :: __construct()
     *
     * @since  2018-11-13
     */
    public function aclRoleConstruct(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - __construct()');

        $role = new Role('Administrator');

        $I->assertInstanceOf(
            Role::class,
            $role
        );
    }

    /**
     * Tests Cardoe\Acl\Role :: __construct() - wildcard
     *
     * @since  2018-11-13
     */
    public function aclRoleConstructWithWildcardThrowsException(UnitTester $I)
    {
        $I->wantToTest('Acl\Role - __construct() - exception with "*"');

        $I->expectThrowable(
            new Exception("Role name cannot be '*'"),
            function () {
                $role = new Role('*');
            }
        );
    }
}
