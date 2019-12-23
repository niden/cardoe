<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Message\Uri;

use Phalcon\Http\Message\Uri;
use UnitTester;

class GetPortCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: getPort()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetPort(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getPort()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 8080;
        $actual   = $uri->getPort();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Http\Message\Uri :: getPort() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetPortEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getPort() - empty');
        $query = 'https://cardoe:secret@dev.cardoe.ld/action?param=value';
        $uri   = new Uri($query);

        $actual = $uri->getPort();
        $I->assertNull($actual);
    }
}
