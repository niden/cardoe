<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Cookies\Cookie;

use Cardoe\Http\Cookies\Cookie;
use Codeception\Example;
use DateTime;
use UnitTester;

class IsSameDomainCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: isSameDomain()
     *
     * @dataProvider getExamples
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieIsSameDomain(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - isSameDomain() ' . $example[0]);

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $cookie->setDomain($example[1]);

        $actual = $cookie->isSameDomain($example[2]);
        $I->assertEquals($actual, $example[3]);
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                'empty',
                '',
                '.cardoe.ld',
                false,
            ],
            [
                'IP',
                '.cardoe.ld',
                '127.0.0.1',
                false,
            ],
            [
                'Same',
                '.cardoe.ld',
                '.cardoe.ld',
                true,
            ],
            [
                'Subdomain',
                '.cardoe.ld',
                '.beta.cardoe.ld',
                true,
            ],
        ];
    }
}
