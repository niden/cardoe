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
use DateTime;
use InvalidArgumentException;
use UnitTester;

class WithExpiresCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withExpires()
     *
     * @dataProvider getExamples
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithExpires(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - withExpires()');

        $cookie = new Cookie('one');
        $clone  = $cookie
            ->withExpires($example[0]);

        $I->assertEquals(0, $cookie->getExpires());
        $I->assertEquals($example[1], $clone->getExpires());
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: withExpires() - exception
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithExpiresException(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - withExpires() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "Invalid expires '2019-12-25 err:err:err' provided"
            ),
            function () {
                $cookie = new Cookie('one');
                $clone  = $cookie
                    ->withExpires(
                        '2019-12-25 err:err:err'
                    );
            }
        );
    }

    private function getExamples(): array
    {
        return [
            [
                100,
                100,
            ],
            [
                '100',
                100,
            ],
            [
                new DateTime('2019-12-25 01:02:03'),
                (new DateTime('2019-12-25 01:02:03'))->getTimestamp(),
            ],
            [
                '2019-12-25 01:02:03',
                (new DateTime('2019-12-25 01:02:03'))->getTimestamp(),
            ],
        ];
    }
}
