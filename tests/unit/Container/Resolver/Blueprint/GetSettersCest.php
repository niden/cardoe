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

class GetSettersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: getSetters()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintGetSetters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - getSetters()');

        $source = [
            'one' => 'setter 1',
            'two' => 'setter 2',
            0     => 'setter 3',
            1     => 'setter 4',
        ];

        $blueprint = new Blueprint(
            'someClass',
            [],
            $source,
            []
        );

        $I->assertEquals($source, $blueprint->getSetters());
    }
}
