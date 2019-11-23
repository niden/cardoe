<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Cookies\Cookie;

use Codeception\Example;
use Cardoe\Http\Cookies\Cookie;
use UnitTester;

class IsMatchCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: isMatch()
     *
     * @dataProvider getExamples
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieIsMatch(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - isMatch()');

        $cookie = new Cookie('one');
        $cookie->setSecure($example[0]);

        if (!empty($example[1])) {
            $cookie->setDomain($example[1]);
        }

        if (!empty($example[2])) {
            $cookie->setPath($example[2]);
        }

        $I->assertEquals(
            $example[3],
            $cookie->isMatch(
                $example[4],
                $example[5],
                $example[6]
            )
        );

//        $cookie
//            ->setDomain('http://phalcon.ld')
//        ;
//
//
//        $cookie->setPath('/a/b/c');
//        $I->assertEquals('/a/b/c', $cookie->getPath());
    }

    private function getExamples(): array
    {
        return [
            [
                false,
                '',
                '',
                false,
                'https',
                'phalcon.ld',
                '/account',
            ],
            [
                true,
                '',
                '',
                false,
                'http',
                'phalcon.ld',
                '/account',
            ],
            [
                true,
                '',
                '',
                false,
                'https',
                'phalcon.ld',
                '/account',
            ],
            [
                true,
                'phalcon.io',
                '',
                false,
                'https',
                'phalcon.ld',
                '/account',
            ],
            [
                true,
                'phalcon.ld',
                '/account',
                true,
                'https',
                'phalcon.ld',
                '/account',
            ],
        ];
    }
}
