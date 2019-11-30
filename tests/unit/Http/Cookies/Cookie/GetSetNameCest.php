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
use InvalidArgumentException;
use UnitTester;
use function chr;

class GetSetNameCest
{
    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getName()/setName()
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetName(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getName()/setName()');

        $cookie = new Cookie(
            [
                'Name' => 'one',
            ]
        );

        $I->assertEquals('one', $cookie->getName());
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getName()/setName() - empty
     *
     * @since  2019-11-22
     */
    public function httpCookiesCookieGetSetNameEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Cookies\Cookie - getName()/setName() - empty');

        $I->expectThrowable(
            new InvalidArgumentException(
                'The cookie name cannot be empty'
            ),
            function () {
                $cookie = new Cookie(
                    [
                        'Name' => 'one',
                    ]
                );
                $cookie->setName('');
            }
        );
    }

    /**
     * Tests Cardoe\Http\Cookies\Cookie :: getName()/setName() - invalid
     * characters
     *
     * @dataProvider getExamples
     *
     * @since        2019-11-22
     */
    public function httpCookiesCookieGetSetNameInvalidCharacters(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Cookies\Cookie - getName()/setName() - invalid characters ' . $example[0]);

        $I->expectThrowable(
            new InvalidArgumentException(
                "The cookie name cannot contain invalid characters: " .
                " ASCII (0-31;127), space, tab and ()<>@,;:\"/?={}';"
            ),
            function () use ($example) {
                $cookie = new Cookie(
                    [
                        'Name' => 'one',
                    ]
                );
                $cookie->setName($example[1]);
            }
        );
    }

    /**
     * @return array
     */
    private function getExamples(): array
    {
        return [
            ["tab", "\t"],
            ["space", " "],
            ["chr(0)", chr(0)],
            ["chr(1)", chr(1)],
            ["chr(2)", chr(2)],
            ["chr(3)", chr(3)],
            ["chr(4)", chr(4)],
            ["chr(5)", chr(5)],
            ["chr(6)", chr(6)],
            ["chr(7)", chr(7)],
            ["chr(8)", chr(8)],
            ["chr(9)", chr(9)],
            ["chr(10)", chr(10)],
            ["chr(11)", chr(11)],
            ["chr(12)", chr(12)],
            ["chr(13)", chr(13)],
            ["chr(14)", chr(14)],
            ["chr(15)", chr(15)],
            ["chr(16)", chr(16)],
            ["chr(17)", chr(17)],
            ["chr(18)", chr(18)],
            ["chr(19)", chr(19)],
            ["chr(20)", chr(20)],
            ["chr(21)", chr(21)],
            ["chr(22)", chr(22)],
            ["chr(23)", chr(23)],
            ["chr(24)", chr(24)],
            ["chr(25)", chr(25)],
            ["chr(26)", chr(26)],
            ["chr(27)", chr(27)],
            ["chr(28)", chr(28)],
            ["chr(29)", chr(29)],
            ["chr(30)", chr(30)],
            ["chr(31)", chr(31)],
            ["chr(127)", chr(127)],
            ["(", "("],
            [")", ")"],
            ["<", "<"],
            [">", ">"],
            ["@", "@"],
            [",", ","],
            [";", ";"],
            [":", ":"],
            ['"', '"'],
            ["/", "/"],
            ["?", "?"],
            ["=", "="],
            ["{", "{"],
            ["}", "}"],
            [";", ";"],
        ];
    }
}
