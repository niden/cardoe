<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use Codeception\Example;
use InvalidArgumentException;
use UnitTester;

class WithUserInfoCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: withUserInfo()
     *
     * @dataProvider getExamples
     *
     * @since        2019-02-09
     */
    public function httpMessageUriWithUserInfo(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Uri - withUserInfo()');

        $query = 'https://%s@dev.cardoe.ld:8080/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, 'zephir:module')
        );

        $newInstance = $uri->withUserInfo($example[1], $example[2]);

        $I->assertNotEquals($uri, $newInstance);

        $I->assertEquals(
            $example[3],
            $newInstance->getUserInfo()
        );

        $I->assertEquals(
            sprintf($query, $example[3]),
            (string) $newInstance
        );
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: withUserInfo() - exception no string
     *
     * @dataProvider getExceptions
     *
     * @since        2019-02-07
     */
    public function httpUriWithUserInfoException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withUserInfo() - exception - ' . $example[1]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Method requires a string argument'
            ),
            function () use ($example) {
                $query = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
                $uri   = new Uri($query);

                $instance = $uri->withUserInfo($example[2]);
            }
        );
    }

    private function getExamples(): array
    {
        return [
            ['valid', 'cardoe', 'secret', 'cardoe:secret'],
            ['user only', 'cardoe', '', 'cardoe'],
            ['email', 'cardoe@secret', 'secret@cardoe', 'cardoe%40secret:secret%40cardoe'],
            ['email', 'cardoe:secret', 'secret:cardoe', 'cardoe%3Asecret:secret%3Acardoe'],
            ['percent', 'cardoe%secret', 'secret%cardoe', 'cardoe%25secret:secret%25cardoe'],
        ];
    }

    private function getExceptions(): array
    {
        return [
            ['NULL', 'null', null],
            ['boolean', 'true', true],
            ['boolean', 'false', false],
            ['integer', 'number', 1234],
            ['array', 'array', ['/action']],
            ['stdClass', 'object', (object) ['/action']],
        ];
    }
}
