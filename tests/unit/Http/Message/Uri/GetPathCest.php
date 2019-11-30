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

class GetPathCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getPath()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetPath(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getPath()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = '/action';
        $actual   = $uri->getPath();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getPath() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetPathEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getPath() - empty');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080';
        $uri   = new Uri($query);

        $actual = $uri->getPath();
        $I->assertEmpty($actual);
    }
}
