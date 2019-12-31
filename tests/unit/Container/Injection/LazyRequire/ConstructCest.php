<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Injection\LazyRequire;

use Phalcon\Container\Injection\LazyInterface;
use Phalcon\Container\Injection\LazyRequire;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\Injection\LazyRequire :: __construct()
     *
     * @since  2019-12-30
     */
    public function containerInjectionLazyRequireConstruct(UnitTester $I)
    {
        $I->wantToTest('Container\Injection\LazyRequire - __construct()');

        $file = dataDir('fixtures/Container/LazyArray.php');
        $injector = new LazyRequire($file);

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
