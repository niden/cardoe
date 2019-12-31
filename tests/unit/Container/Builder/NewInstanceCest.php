<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Builder;

use UnitTester;

class NewInstanceCest
{
    /**
     * Unit Tests Phalcon\Container\Builder :: newInstance()
     *
     * @since  2019-12-30
     */
    public function containerBuilderNewInstance(UnitTester $I)
    {
        $I->wantToTest('Container\Builder - newInstance()');

        $I->skipTest('Need implementation');
    }
}
