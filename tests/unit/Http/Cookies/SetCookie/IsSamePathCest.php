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

class IsSamePathCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: isSamePath()
     *
     * @dataProvider getExamples
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieIsSamePath(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - isSamePath() - ' . $example[0]);

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $cookie->setPath($example[1]);

        $actual = $cookie->isSamePath($example[2]);
        $I->assertEquals($actual, $example[3]);
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            [
                '/',
                '/',
                '',
                true,
            ],
            [
                'same',
                '/abc',
                '/abc',
                true,
            ],
            [
                'prefix',
                '/invoices/views',
                '/invoices',
                false,
            ],
            [
                'last character',
                '/abc/',
                '/abc/def',
                true,
            ],
            [
                'first character',
                '/abc',
                '/abc/',
                true,
            ],
        ];
    }
}
