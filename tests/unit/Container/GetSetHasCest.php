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
use Phalcon\Container\Exception\ServiceNotFound;
use UnitTester;

class GetCest
{
    /**
     * Unit Tests Phalcon\Container :: get()
     *
     * @since  2020-01-01
     */
    public function containerGet(UnitTester $I)
    {
        $I->wantToTest('Container - get()');

        $I->expectThrowable(
            new ServiceNotFound(
                "Service not defined: 'unknown'"
            ),
            function () {
                $builder   = new Builder();
                $container = $builder->newInstance();
                $container->get('unknown');
            }
        );
    }
}
