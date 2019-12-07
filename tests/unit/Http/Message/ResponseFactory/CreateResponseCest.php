<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ResponseFactory;

use Cardoe\Http\Message\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use UnitTester;

class CreateResponseCest
{
    /**
     * Tests Cardoe\Http\Message\ResponseFactory :: createResponse()
     *
     * @since  2019-02-10
     */
    public function httpMessageResponseFactoryCreateResponse(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ResponseFactory - createResponse()');
        $factory  = new ResponseFactory();
        $response = $factory->createResponse();
        $class    = ResponseInterface::class;
        $I->assertInstanceOf($class, $response);
    }
}
