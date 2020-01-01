<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Phalcon\Container\Builder;
use Phalcon\Container\Injection\LazyInterface;
use UnitTester;

class LazyRequireCest
{
    /**
     * Unit Tests Phalcon\Container :: lazyRequire()
     *
     * @since  2020-01-01
     */
    public function containerLazyRequire(UnitTester $I)
    {
        $I->wantToTest('Container - lazyRequire()');

        $file      = dataDir('fixtures/Container/LazyArray.php');
        $builder   = new Builder();
        $container = $builder->newInstance();

        $lazy = $container->lazyRequire($file);
        $I->assertInstanceOf(LazyInterface::class, $lazy);
        $actual = $lazy();

        $I->assertEquals(
            [
                'starship' => 'Voyager',
            ],
            $actual
        );
    }
}