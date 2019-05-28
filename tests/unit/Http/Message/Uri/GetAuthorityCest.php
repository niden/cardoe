<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Uri;

use Cardoe\Http\Message\Uri;
use Codeception\Example;
use UnitTester;

class GetAuthorityCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: getAuthority()
     *
     * @dataProvider getExamples
     *
     * @since        2019-02-09
     */
    public function httpMessageUriGetAuthority(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Message\Uri - getAuthority()');

        $uri = new Uri(
            $example[1]
        );

        $I->assertEquals(
            $example[2],
            $uri->getAuthority()
        );
    }

    private function getExamples(): array
    {
        return [
            [
                'empty',
                '',
                '',
            ],

            [
                'default',
                'https://dev.cardoe.ld',
                'dev.cardoe.ld',
            ],

            [
                'with user info',
                'https://cardoe:secret@dev.cardoe.ld',
                'cardoe:secret@dev.cardoe.ld',
            ],

            [
                'with port',
                'https://dev.cardoe.ld:8080',
                'dev.cardoe.ld:8080',
            ],

            [
                'full',
                'https://cardoe:secret@dev.cardoe.ld:8080',
                'cardoe:secret@dev.cardoe.ld:8080',
            ],
        ];
    }
}
