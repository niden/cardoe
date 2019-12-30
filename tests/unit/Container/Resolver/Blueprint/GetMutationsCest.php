<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\Blueprint;

use Phalcon\Container\Resolver\Blueprint;
use UnitTester;

class GetMutationsCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: getMutations()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintGetMutations(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - getMutations()');

        $source = [
            'one' => 'mutation 1',
            'two' => 'mutation 2',
            0     => 'mutation 3',
            1     => 'mutation 4',
        ];

        $blueprint = new Blueprint(
            'someClass',
            [],
            [],
            $source
        );

        $I->assertEquals($source, $blueprint->getMutations());
    }
}
