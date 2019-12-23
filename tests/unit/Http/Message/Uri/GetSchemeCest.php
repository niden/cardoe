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

class GetSchemeCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: getScheme()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetScheme(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getScheme()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'https';
        $actual   = $uri->getScheme();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Http\Message\Uri :: getScheme() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetSchemeEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getScheme() - empty');
        $query = '//cardoe:secret@dev.cardoe.ld:8080/action?param=value';
        $uri   = new Uri($query);

        $actual = $uri->getScheme();
        $I->assertEmpty($actual);
    }
}
