<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Component;

use Cardoe\Acl\Component;
use UnitTester;

class GetDescriptionCest
{
    /**
     * Tests Cardoe\Acl\Component :: getDescription()
     *
     * @since  2018-11-13
     */
    public function aclComponentGetDescription(UnitTester $I)
    {
        $I->wantToTest('Acl\Component - getDescription()');

        $component = new Component('Customers', 'Customer management');

        $I->assertEquals(
            'Customer management',
            $component->getDescription()
        );
    }

    /**
     * Tests Cardoe\Acl\Component :: getDescription() - empty
     *
     * @since  2018-11-13
     */
    public function aclComponentGetDescriptionEmpty(UnitTester $I)
    {
        $I->wantToTest("Acl\Component - getDescription() - empty");

        $component = new Component('Customers');

        $I->assertEmpty(
            $component->getDescription()
        );
    }
}
