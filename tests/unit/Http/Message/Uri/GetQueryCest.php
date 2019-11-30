<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use UnitTester;

class GetQueryCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getQuery()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetQuery(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getQuery()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'param=value';
        $actual   = $uri->getQuery();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getQuery() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetQueryEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getQuery() - empty');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action';
        $uri   = new Uri($query);

        $actual = $uri->getQuery();
        $I->assertEmpty($actual);
    }
}
