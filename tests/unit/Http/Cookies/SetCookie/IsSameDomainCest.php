<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Cookies\SetCookie;

use Cardoe\Http\Cookies\SetCookie;
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

        $cookie = new SetCookie(
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
