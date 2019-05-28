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
use Cardoe\Http\Message\Uri;
use UnitTester;

class WithPortCest
{
    /**
     * Tests Cardoe\Http\Message\Uri :: withPort()
     *
     * @since  2019-02-09
     */
    public function httpMessageUriWithPort(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Uri - withPort()');

        $query = 'https://cardoe:secret@dev.cardoe.ld:%s/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, 3306)
        );

        $newInstance = $uri->withPort(11211);

        $I->assertNotEquals($uri, $newInstance);

        $I->assertEquals(
            11211,
            $newInstance->getPort()
        );

        $I->assertEquals(
            sprintf($query, 11211),
            (string) $newInstance
        );
    }

    /**
     * Tests Cardoe\Http\Message\Uri :: withPort() - exception no string
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@cardoephp.com>
     * @since        2019-02-07
     */
    public function httpUriWithPortException(UnitTester $I, Example $example)
    {
        $I->wantToTest('Http\Uri - withPort() - ' . $example[0]);

        $query = 'https://cardoe:secret@dev.cardoe.ld%s/action?param=value#frag';

        $uri = new Uri(
            sprintf($query, ':4300')
        );

        $newInstance = $uri->withPort($example[1]);

        $I->assertNotEquals(
            $uri,
            $newInstance
        );

        $I->assertEquals(
            $example[2],
            $newInstance->getPort()
        );

        $I->assertEquals(
            sprintf($query, $example[3]),
            (string) $newInstance
        );
    }

    private function getExamples(): array
    {
        return [
            ['null', null, null, ''],
            ['int', 8080, 8080, ':8080'],
            ['string-int', '8080', 8080, ':8080'],
            ['http', 80, null, ''],
            ['https', 443, null, ''],
        ];
    }
}
