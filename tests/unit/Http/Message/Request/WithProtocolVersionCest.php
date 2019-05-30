<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\Request;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Request;
use UnitTester;

class WithProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\Request :: withProtocolVersion()
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withProtocolVersion()');

        $request = new Request();

        $newInstance = $request->withProtocolVersion('2.0');

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            '1.1',
            $request->getProtocolVersion()
        );

        $I->assertEquals(
            '2.0',
            $newInstance->getProtocolVersion()
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: withProtocolVersion() - unsupported protocol
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithProtocolVersionEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withProtocolVersion() - unsupported protocol');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Invalid protocol value'
            ),
            function () {
                $request = new Request();

                $newInstance = $request->withProtocolVersion('');
            }
        );
    }

    /**
     * Tests Cardoe\Http\Message\Request :: withProtocolVersion() - empty protocol
     *
     * @since  2019-02-10
     */
    public function httpMessageRequestWithProtocolVersionUnsupported(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Request - withProtocolVersion() - empty protocol');

        $I->expectThrowable(
            new InvalidArgumentException(
                'Unsupported protocol 4.0'
            ),
            function () {
                $request = new Request();

                $newInstance = $request->withProtocolVersion('4.0');
            }
        );
    }
}
