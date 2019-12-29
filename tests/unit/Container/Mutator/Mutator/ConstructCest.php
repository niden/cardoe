<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutator;

use Phalcon\Container\Mutator\Mutator;
use Phalcon\Container\Mutator\MutatorInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: __construct()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - __construct()');

        $mutator = new Mutator("myClass");
        $I->assertInstanceOf(MutatorInterface::class, $mutator);
    }
}
