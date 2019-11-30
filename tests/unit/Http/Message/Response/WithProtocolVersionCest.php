<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Response;

use Cardoe\Http\Message\Response;
use InvalidArgumentException;
use UnitTester;

class WithProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: withProtocolVersion()
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withProtocolVersion()');
        $response    = new Response();
        $newInstance = $response->withProtocolVersion('2.0');

        $I->assertNotEquals($response, $newInstance);

        $expected = '1.1';
        $actual   = $response->getProtocolVersion();
        $I->assertEquals($expected, $actual);

        $expected = '2.0';
        $actual   = $newInstance->getProtocolVersion();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\Response :: withProtocolVersion() - exception
     *
     * @since  2019-03-09
     */
    public function httpMessageResponseWithProtocolVersionException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - withProtocolVersion() - exception');
        $I->expectThrowable(
            new InvalidArgumentException('Unsupported protocol 1.2'),
            function () {
                $response = new Response();
                $response->withProtocolVersion('1.2');
            }
        );
    }
}
