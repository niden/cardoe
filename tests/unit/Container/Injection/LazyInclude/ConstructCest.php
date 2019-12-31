<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\LazyInclude;

use Phalcon\Container\Injection\LazyInclude;
use Phalcon\Container\Injection\LazyInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyInclude :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyIncludeConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyInclude - __construct()');

        $file = dataDir('fixtures/Container/LazyArray.php');
        $injector = new LazyInclude($file);

        $I->assertInstanceOf(LazyInterface::class, $injector);
        $actual = $injector();

        $I->assertEquals(
            [
                'starship' => 'Voyager',
            ],
            $actual
        );
    }
}
