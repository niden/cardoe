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

class WithParamsCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: withParams()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintWithParams(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - withParams()');

        $sourceParameters = [
            'one' => 'parameter 1',
            'two' => 'parameter 2',
        ];

        $source = new Blueprint('parentClass', $sourceParameters);
        $I->assertEquals($sourceParameters, $source->getParameters());

        $targetParameters = [
            'one' => 'parameter 3',
            'two' => 'parameter 4',
        ];

        $target = $source->withParams($targetParameters);
        $I->assertInstanceOf(Blueprint::class, $target);
        $I->assertNotEquals(spl_object_hash($source), spl_object_hash($target));
        $I->assertEquals($targetParameters, $target->getParameters());
    }
}
