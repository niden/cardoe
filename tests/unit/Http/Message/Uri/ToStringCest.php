<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use UnitTester;

class ToStringCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: __toString()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriToString(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - __toString()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $I->assertEquals($query, (string) $uri);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: __toString() - path no lead slash
     *
     * @since  2019-02-07
     */
    public function httpUriToStringPathNoLeadSlash(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - __toString() - path no lead slash');
        $uri = new Uri('https://dev.cardoe.ld');

        $newInstance = $uri->withPath('action/reaction');
        $expected    = 'https://dev.cardoe.ld/action/reaction';
        $actual      = $newInstance->__toString();
        $I->assertEquals($expected, $actual);
    }
}
