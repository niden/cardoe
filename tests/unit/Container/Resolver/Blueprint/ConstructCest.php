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

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\Blueprint :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerResolverBlueprintConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\Blueprint - __construct()');

        $blueprint = new Blueprint('someClass');
        $I->assertInstanceOf(Blueprint::class, $blueprint);
    }
}
