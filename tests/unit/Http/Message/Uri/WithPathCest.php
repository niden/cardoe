<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Codeception\Example;
use InvalidArgumentException;
use Cardoe\Http\Message\Uri;
use UnitTester;

class WithPathCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: withPath()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@cardoephp.com>
     * @since        2019-02-09
     */
    public function httpMessageUriWithPath(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Uri - withPath() - ' . $example[0]);

        $query = 'https://dev.cardoe.ld%s';

        $uri = new Uri(
            sprintf($query, '/action')
        );

        $newInstance = $uri->withPath(
            $example[1]
        );

        $I->assertNotEquals(
            $uri,
            $newInstance
        );

        $I->assertEquals(
            $example[2],
            $newInstance->getPath()
        );

        $I->assertEquals(
            sprintf($query, $example[3]),
            (string) $newInstance
        );
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: withPath() - exception no string
     *
     * @dataProvider getExceptions
     *
     * @author       Cardoe Team <team@cardoephp.com>
     * @since        2019-02-07
     */
    public function httpUriWithPathException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withPath() - exception - ' . $example[1]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Method requires a string argument instead of ' . $example[0]
            ),
            function () use ($example) {
                $query    = 'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag';
                $uri      = new Uri($query);
                $instance = $uri->withPath($example[2]);
            }
        );
    }

    private function getExamples(): array
    {
        return [
            ['empty', '', '', ''],
            ['normal', '/login', '/login', '/login'],
            ['double slash', '//login', '/login', '/login'],
            ['no leading slash', 'login', 'login', '/login'],
            ['garbled', '/l^ogin/si gh', '/l%5Eogin/si%20gh', '/l%5Eogin/si%20gh'],
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
