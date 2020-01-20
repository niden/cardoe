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

namespace Phalcon\Test\Integration\DM\Query\Bind;

use IntegrationTester;
use PDO;
use Phalcon\DM\Query\Bind;

class RemoveCest
{
    /**
     * Integration Tests Phalcon\DM\Query\Bind :: remove()
     *
     * @since  2020-01-20
     */
    public function dMQueryBindRemove(IntegrationTester $I)
    {
        $I->wantToTest('DM\Query\Bind - remove()');

        $bind = new Bind();

        $expected = [];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);

        $bind->inline("one");
        $bind->inline(true, PDO::PARAM_BOOL);

        $expected = [
            "__1__" => ["one", 2],
            "__2__" => [1, 5],
        ];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);

        $bind->remove("__1__");

        $expected = [
            "__2__" => [1, 5],
        ];
        $actual   = $bind->toArray();
        $I->assertEquals($expected, $actual);
    }
}
