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

class MergeCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: merge()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintMerge(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - merge()');

        $sourceParameters = [
            0     => 'parameter 0',
            'one' => 'parameter 1',
            'two' => 'parameter 2',
        ];
        $sourceSetters    = [
            'one' => 'setter 1',
            'two' => 'setter 2',
        ];
        $sourceMutators   = [
            'one' => 'mutator 1',
            'two' => 'mutator 2',
        ];

        $source = new Blueprint(
            'parentClass',
            $sourceParameters,
            $sourceSetters,
            $sourceMutators
        );

        $I->assertEquals($sourceParameters, $source->getParameters());
        $I->assertEquals($sourceSetters, $source->getSetters());
        $I->assertEquals($sourceMutators, $source->getMutations());

        $targetParameters = [
            0     => 'parameter 10',
            'one' => 'parameter 3',
            'two' => 'parameter 4',
        ];
        $targetSetters    = [
            'one' => 'setter 3',
            'two' => 'setter 4',
        ];
        $targetMutators   = [
            'one' => 'mutator 3',
            'two' => 'mutator 4',
        ];

        $target = new Blueprint(
            'childClass',
            $targetParameters,
            $targetSetters,
            $targetMutators
        );

        $I->assertEquals($targetParameters, $target->getParameters());
        $I->assertEquals($targetSetters, $target->getSetters());
        $I->assertEquals($targetMutators, $target->getMutations());

        $merged = $source->merge($target);
        $I->assertInstanceOf(Blueprint::class, $merged);
        $I->assertNotEquals(spl_object_hash($source), spl_object_hash($merged));

        $I->assertEquals($targetParameters, $merged->getParameters());
        $I->assertEquals($targetSetters, $merged->getSetters());
        $I->assertEquals($targetMutators, $merged->getMutations());

        $target = new Blueprint('grandChild');
        $merged = $source->merge($target);
        $I->assertInstanceOf(Blueprint::class, $merged);
        $I->assertNotEquals(spl_object_hash($source), spl_object_hash($merged));

        $I->assertEquals($sourceParameters, $merged->getParameters());
        $I->assertEquals($sourceSetters, $merged->getSetters());
        $I->assertEquals($sourceMutators, $merged->getMutations());
    }
}
