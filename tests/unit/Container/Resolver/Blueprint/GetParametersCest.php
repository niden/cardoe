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

class GetParametersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: getParameters()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintGetParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - getParameters()');

        $source = [
            'one' => 'parameter 1',
            'two' => 'parameter 2',
            0     => 'parameter 3',
            1     => 'parameter 4',
        ];

        $blueprint = new Blueprint(
            'someClass',
            $source,
            [],
            []
        );

        $I->assertEquals($source, $blueprint->getParameters());
    }
}
