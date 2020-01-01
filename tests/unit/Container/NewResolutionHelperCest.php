<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use Codeception\Stub;
use Phalcon\Container;
use Phalcon\Container\ResolutionHelper;
use UnitTester;

class NewResolutionHelperCest
{
    /**
     * Unit Tests Phalcon\Container :: newResolutionHelper()
     *
     * @since  2019-12-30
     */
    public function containerNewResolutionHelper(UnitTester $I)
    {
        $I->wantToTest('Container - newResolutionHelper()');

        $container = Stub::make(Container::class);
        $helper    = $container->newResolutionHelper();

        $I->assertInstanceOf(ResolutionHelper::class, $helper);
    }
}
