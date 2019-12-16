<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\JWT\Encoder\Hmac;

use Phalcon\Http\JWT\Encoder\Hmac;
use UnitTester;

class GetAlgorithmCest
{
    /**
     * Unit Tests Phalcon\Http\JWT\Encoder\Hmac :: getAlgorithm()
     *
     * @since  2019-12-15
     */
    public function httpJWTEncoderHmacGetAlgorithm(UnitTester $I)
    {
        $I->wantToTest('Http\JWT\Encoder\Hmac - getAlgorithm()');

        $encoder = new Hmac();
        $I->assertEquals('sha512', $encoder->getAlgorithm());

        $encoder = new Hmac('sha512');
        $I->assertEquals('sha512', $encoder->getAlgorithm());

        $encoder = new Hmac('sha384');
        $I->assertEquals('sha384', $encoder->getAlgorithm());

        $encoder = new Hmac('sha256');
        $I->assertEquals('sha256', $encoder->getAlgorithm());
    }
}
