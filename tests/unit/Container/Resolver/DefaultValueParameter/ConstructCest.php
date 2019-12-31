<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\DefaultValueParameter;

use Phalcon\Container\Resolver\DefaultValueParameter;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\DefaultValueParameter ::
     * __construct()
     *
     * @since  2019-12-30
     */
    public function containerResolverDefaultValueParameterConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\DefaultValueParameter - __construct()');

        $parameter = new DefaultValueParameter('seven', 'of nine');

        $I->assertInstanceOf(DefaultValueParameter::class, $parameter);
        $I->assertEquals('seven', $parameter->getName());
        $I->assertEquals('of nine', $parameter->getValue());
    }
}
