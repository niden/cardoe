<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\UnresolvedParameter;

use Phalcon\Container\Resolver\UnresolvedParameter;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\UnresolvedParameter ::
     * __construct()
     *
     * @since  2019-12-30
     */
    public function containerResolverUnresolvedParameterConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\UnresolvedParameter - __construct()');

        $parameter = new UnresolvedParameter('seven');

        $I->assertInstanceOf(UnresolvedParameter::class, $parameter);
        $I->assertEquals('seven', $parameter->getName());
    }
}
