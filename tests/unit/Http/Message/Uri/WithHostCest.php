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

class WithHostCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: withHost()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriWithHost(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - withHost()');

        $query = 'https://cardoe:secret@%s:8080/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, 'dev.cardoe.ld')
        );

        $newInstance = $uri->withHost('prod.cardoe.ld');

        $I->assertNotEquals($uri, $newInstance);

        $I->assertEquals(
            'prod.cardoe.ld',
            $newInstance->getHost()
        );

        $I->assertEquals(
            sprintf($query, 'prod.cardoe.ld'),
            (string) $newInstance
        );
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: withHost() - exception no string
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@cardoephp.com>
     * @since        2019-02-07
     */
    public function httpUriWithHostException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withHost() - exception - ' . $example[1]);

        $I->expectThrowable(
            new InvalidArgumentException(
                'Method requires a string argument instead of ' . $example[0]
            ),
            function () use ($example) {
                $uri = new Uri(
                    'https://cardoe:secret@dev.cardoe.ld:8080/action?param=value#frag'
                );

                $instance = $uri->withHost($example[2]);
            }
        );
    }

    private function getExamples(): array
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
