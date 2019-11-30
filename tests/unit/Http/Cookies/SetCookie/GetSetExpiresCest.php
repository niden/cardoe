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
use InvalidArgumentException;
use UnitTester;

class GetSetExpiresCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getExpires()/setExpires()
     *
     * @dataProvider getExamples
     *
     * @since        2019-11-22
     */
    public function httpCookiesCookieWithExpires(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - getExpires()/setExpires()');

        $cookie = new SetCookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertEquals(0, $cookie->getExpires());

        $cookie->setExpires($example[0]);
        $I->assertEquals($example[1], $cookie->getExpires());
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getExpires()/setExpires() - exception
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieWithExpiresException(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getExpires()/setExpires() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "Invalid expires '2019-12-15 01:dd:ee' provided"
            ),
            function () {
                $cookie = new SetCookie(
                    [
                        'Name' => 'one',
                    ]
                );
                $cookie->setExpires("2019-12-15 01:dd:ee");
            }
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
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
