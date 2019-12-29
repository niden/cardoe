<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutators;

use Phalcon\Container\Mutator\Mutators;
use Phalcon\Test\Fixtures\Container\FourClass;
use Phalcon\Test\Fixtures\Container\TwoClass;
use UnitTester;

class ToArrayCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutators :: toArray()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorsToArray(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutators - toArray()');

        $mutators = new Mutators();
        $mutator1 = $mutators->add(TwoClass::class);
        $mutator2 = $mutators->add(FourClass::class);

        $results = $mutators->toArray();
        $I->assertIsArray($results);
        $I->assertCount(2, $results);
        $I->assertEquals(
            [
                TwoClass::class  => [$mutator1],
                FourClass::class => [$mutator2],
            ],
            $results
        );
    }
}
