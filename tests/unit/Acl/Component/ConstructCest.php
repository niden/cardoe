<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Component;

use BadMethodCallException;
use Cardoe\Acl\Component;
use Cardoe\Acl\Exception;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Acl\Component :: __construct()
     *
     * @since  2018-11-13
     */
    public function aclComponentConstruct(UnitTester $I)
    {
        $I->wantToTest('Acl\Component - __construct()');

        $component = new Component('Customers');

        $I->assertInstanceOf(
            Component::class,
            $component
        );
    }

    /**
     * Tests Cardoe\Acl\Component :: __construct() - wildcard
     *
     * @since  2018-11-13
     */
    public function aclComponentConstructWithWildcardThrowsException(UnitTester $I)
    {
        $I->wantToTest('Acl\Component - __construct() - exception with "*"');

        $I->expectThrowable(
            new Exception("Component name cannot be '*'"),
            function () {
                $component = new Component('*');
            }
        );
    }
}
