<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Domain\Payload\Payload;

use Cardoe\Domain\Payload\Payload;
use RuntimeException;
use UnitTester;

class GetSetExceptionCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getException()/setException()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetSetException(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getException()/setException()');

        $payload   = new Payload();
        $exception = new RuntimeException('Runtime error');
        $payload->setException($exception);

        $actual = $payload->getException();
        $I->assertEquals($exception, $actual);
    }
}
