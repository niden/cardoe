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

class GetFragmentCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getFragment()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriGetFragment(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - getFragment()');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
        $uri   = new Uri($query);

        $expected = 'frag';
        $actual   = $uri->getFragment();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: getFragment() - empty
     *
     * @since  2019-02-07
     */
    public function httpUriGetFragmentEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Uri - getFragment() - empty');
        $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value';
        $uri   = new Uri($query);

        $actual = $uri->getFragment();
        $I->assertEmpty($actual);
    }
}
