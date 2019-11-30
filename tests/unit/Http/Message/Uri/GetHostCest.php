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

class GetHostCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getHost()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetHost(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getHost()');

        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'dev.cardoe.ld';
        $actual   = $uri->getHost();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getHost() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetHostEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getHost() - empty');

        $query = 'https://';
        $uri   = new Uri($query);

        $actual = $uri->getHost();
        $I->assertEmpty($actual);
    }
}
