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

class ToStringCest
{
    /**
     * Tests Cardoe\Acl\Component :: __toString()
     *
     * @since  2018-11-13
     */
    public function aclComponentToString(UnitTester $I)
    {
        $I->wantToTest('Acl\Component - __toString()');

        $component = new Component('Customers');

        $I->assertEquals(
            'Customers',
            $component->__toString()
        );

        $I->assertEquals(
            'Customers',
            (string) $component
        );
    }
}
