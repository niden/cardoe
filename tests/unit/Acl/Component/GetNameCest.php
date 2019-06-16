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

class GetNameCest
{
    /**
     * Tests Cardoe\Acl\Component :: getName()
     *
     * @since  2018-11-13
     */
    public function aclComponentGetName(UnitTester $I)
    {
        $I->wantToTest('Acl\Component - getName()');

        $component = new Component('Customers');

        $I->assertEquals(
            'Customers',
            $component->getName()
        );
    }
}
