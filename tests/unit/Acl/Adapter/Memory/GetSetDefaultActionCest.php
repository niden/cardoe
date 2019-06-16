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

class GetSetDefaultActionCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getDefaultAction()/setDefaultAction()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetSetDefaultAction(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getDefaultAction()/setDefaultAction()');

        $acl = new Memory();

        $acl->setDefaultAction(
            Memory::ALLOW
        );

        $I->assertEquals(
            Memory::ALLOW,
            $acl->getDefaultAction()
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getDefaultAction()/setDefaultAction()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetSetDefaultActionDefault(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getDefaultAction()/setDefaultAction() - default');

        $acl = new Memory();

        $I->assertEquals(
            Memory::DENY,
            $acl->getDefaultAction()
        );
    }
}
