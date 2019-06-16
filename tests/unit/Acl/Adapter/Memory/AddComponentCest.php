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
use UnitTester;

class AddComponentCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponent() - string
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentString(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponent() - string');

        $acl = new Memory();

        $component = new Component('Customer', 'Customer component');

        $actual = $acl->addComponent(
            'Customer',
            ['index']
        );

        $I->assertTrue($actual);
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponent() - object
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentObject(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponent() - object');

        $acl = new Memory();

        $component = new Component('Customer', 'Customer component');

        $actual = $acl->addComponent(
            $component,
            ['index']
        );

        $I->assertTrue($actual);
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponent() - numeric key
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentNumericKey(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponent() - numeric key');

        $acl = new Memory();

        $component = new Component('11', 'Customer component');

        $actual = $acl->addComponent(
            $component,
            ['index']
        );

        $I->assertTrue($actual);

        $I->assertTrue(
            $acl->isComponent('11')
        );
    }
}
