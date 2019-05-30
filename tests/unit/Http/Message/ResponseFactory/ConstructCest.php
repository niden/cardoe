<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ResponseFactory;

use Cardoe\Http\Message\Response;
use Psr\Http\Message\ResponseInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\Response :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpMessageResponseConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\Message\Response - __construct()');
        $response = new Response();
        $class    = ResponseInterface::class;
        $I->assertInstanceOf($class, $response);
    }
}
