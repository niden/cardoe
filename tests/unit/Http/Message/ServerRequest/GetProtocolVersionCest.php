<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class GetProtocolVersionCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getProtocolVersion()
     *
     * @since  2019-03-05
     */
    public function httpMessageServerRequestGetProtocolVersion(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getProtocolVersion()');
        $request = new ServerRequest(
            'GET',
            null,
            [],
            'php://input',
            [],
            [],
            [],
            [],
            null,
            '2.0'
        );

        $expected = '2.0';
        $actual   = $request->getProtocolVersion();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getProtocolVersion() - empty
     *
     * @since  2019-03-05
     */
    public function httpMessageServerRequestGetProtocolVersionEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getProtocolVersion() - empty');
        $request = new ServerRequest();

        $expected = '1.1';
        $actual   = $request->getProtocolVersion();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getProtocolVersion() -
     * exception
     *
     * @since  2019-03-05
     */
    public function httpMessageServerRequestGetProtocolVersionException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getProtocolVersion() - exception');
        $I->expectThrowable(
            new InvalidArgumentException('Unsupported protocol 1.2'),
            function () {
                $request = new ServerRequest(
                    'GET',
                    null,
                    [],
                    'php://input',
                    [],
                    [],
                    [],
                    [],
                    null,
                    '1.2'
                );
            }
        );
    }
}
