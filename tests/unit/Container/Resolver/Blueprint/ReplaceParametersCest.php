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

class ReplaceParametersCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: replaceParameters()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintReplaceParameters(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - replaceParameters()');

        $sourceParameters = [
            0     => 'parameter 0',
            'one' => 'parameter 1',
            'two' => 'parameter 2',
        ];

        $source = new Blueprint('parentClass', $sourceParameters);
        $I->assertEquals($sourceParameters, $source->getParameters());

        $targetParameters = [
            1      => 'parameter 10',
            'four' => 'parameter 3',
            'five' => 'parameter 4',
        ];

        $target = $source->replaceParameters($targetParameters);
        $I->assertInstanceOf(Blueprint::class, $target);
        $I->assertNotEquals(spl_object_hash($source), spl_object_hash($target));
        $I->assertEquals($targetParameters, $target->getParameters());
    }
}
