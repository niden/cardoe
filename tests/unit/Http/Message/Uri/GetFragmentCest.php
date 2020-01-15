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

namespace Phalcon\Test\Unit\Http\Message\Uri;

use Phalcon\Http\Message\Uri;
use UnitTester;

class GetFragmentCest
{
    /**
     * Tests Phalcon\Http\Message\Uri :: getFragment()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetFragment(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getFragment()');
        $query = 'https://Phalcon:secret@dev.phalcon.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'frag';
        $actual   = $uri->getFragment();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Http\Message\Uri :: getFragment() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetFragmentEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getFragment() - empty');
        $query = 'https://Phalcon:secret@dev.phalcon.ld:8080/action?param=value';
        $uri   = new Uri($query);

        $actual = $uri->getFragment();
        $I->assertEmpty($actual);
    }
}
