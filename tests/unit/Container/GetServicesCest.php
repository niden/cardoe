<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container;

use UnitTester;

class GetServicesCest
{
    /**
     * Unit Tests Phalcon\Container :: getServices()
     *
     * @since  2019-12-30
     */
    public function containerGetServices(UnitTester $I)
    {
        $I->wantToTest('Container - getServices()');

        $I->skipTest('Need implementation');
    }
}
