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

class GetSetNoArgumentsDefaultActionCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory ::
     * getNoArgumentsDefaultAction()/setNoArgumentsDefaultAction()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetSetNoArgumentsDefaultAction(UnitTester $I)
    {
        $I->wantToTest(
            'Acl\Adapter\Memory - getNoArgumentsDefaultAction()/setNoArgumentsDefaultAction()'
        );

        $acl = new Memory();

        $acl->setNoArgumentsDefaultAction(
            Memory::ALLOW
        );

        $I->assertEquals(
            Memory::ALLOW,
            $acl->getNoArgumentsDefaultAction()
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory ::
     * getNoArgumentsDefaultAction()/setNoArgumentsDefaultAction() - default
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryGetSetNoArgumentsDefaultActionDefault(UnitTester $I)
    {
        $I->wantToTest(
            'Acl\Adapter\Memory - getNoArgumentsDefaultAction()/setNoArgumentsDefaultAction() - default'
        );

        $acl = new Memory();

        $I->assertEquals(
            Memory::DENY,
            $acl->getNoArgumentsDefaultAction()
        );
    }
}
