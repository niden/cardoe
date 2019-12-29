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
use UnitTester;

class GetClassNameCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: getClassName()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorGetClassName(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - getClassName()');

        $mutator = new Mutator("myClass");

        $I->assertEquals("myClass", $mutator->getClassName());
    }
}
