<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Integration\DM\Query\QueryFactory;

use IntegrationTester;
use Phalcon\DM\Query\Bind;
use Phalcon\DM\Query\QueryFactory;

class NewBindCest
{
    /**
     * Integration Tests Phalcon\DM\Query\QueryFactory :: newBind()
     *
     * @since  2020-01-20
     */
    public function dMQueryQueryFactoryNewBind(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\QueryFactory - newBind()');

        $factory = new QueryFactory();
        $bind    = $factory->newBind();
        $I->assertInstanceOf(Bind::class, $bind);
    }
}
