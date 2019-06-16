<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Acl\Adapter\Memory;

use Closure;
use Cardoe\Acl\Adapter\Memory;
use Cardoe\Acl\Component;
use Cardoe\Acl\Role;
use UnitTester;

class GetActiveFunctionCest
{
    /**
     * Tests Cardoe\Acl\Adapter\Memory :: getActiveFunction()
     *
     * @author  Wojciech Slawski <jurigag@gmail.com>
     * @since   2017-01-13
     */
    public function aclAdapterMemoryGetActiveFunction(UnitTester $I)
    {
        $I->wantToTest('Acl\Adapter\Memory - getActiveFunction()');

        $function = function ($a) {
            return true;
        };

        $acl = new Memory();

        $acl->addRole(
            new Role('Guests')
        );

        $acl->addComponent(
            new Component('Post'),
            ['index', 'update', 'create']
        );

        $acl->allow('Guests', 'Post', 'create', $function);

        $I->assertTrue(
            $acl->isAllowed(
                'Guests',
                'Post',
                'create',
                [
                    'a' => 1,
                ]
            )
        );


        $returnedFunction = $acl->getActiveFunction();

        $I->assertInstanceOf(
            Closure::class,
            $returnedFunction
        );


        $I->assertEquals(
            1,
            $function(1)
        );

        $I->assertEquals(
            1,
            $acl->getActiveFunctionCustomArgumentsCount()
        );
    }
}
