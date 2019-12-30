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

class GetClassNameCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: getClassName()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintGetClassName(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - getClassName()');

        $blueprint = new Blueprint('someClass');
        $I->assertEquals('someClass', $blueprint->getClassName());
    }
}
