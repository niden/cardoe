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
use Cardoe\Acl\Exception;
use UnitTester;

class AddComponentAccessCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponentAccess()
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentAccess(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponentAccess()');

        $I->skipTest('Need implementation');
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponentAccess() - unknown
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentAccessUnknown(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponentAccess() - unknown');

        $I->expectThrowable(
            new Exception("Component 'Post' does not exist in ACL"),
            function () {
                $acl = new Memory();

                $acl->addComponentAccess(
                    'Post',
                    ['update']
                );
            }
        );
    }

    /**
     * Tests Cardoe\Acl\Adapter\Memory :: addComponentAccess() - wrong access
     * list
     *
     * @since  2018-11-13
     */
    public function aclAdapterMemoryAddComponentAccessWrongAccessList(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - addComponentAccess() - wrong access list');

        $I->expectThrowable(
            new Exception('Invalid value for accessList'),
            function () {
                $acl  = new Memory();
                $post = new Component('Post');

                $acl->addComponent(
                    $post,
                    ['update']
                );

                $acl->addComponentAccess('Post', 123);
            }
        );
    }
}
