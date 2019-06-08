<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Domain\Payload\Payload;

use Cardoe\Domain\Payload\Payload;
use Cardoe\Domain\Payload\Status;
use UnitTester;

class GetSetStatusCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getStatus()/setStatus()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetStatus(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getStatus()/setStatus()');

        $payload = new Payload();
        $payload->setStatus(Status::ACCEPTED);

        $actual = $payload->getStatus();
        $I->assertEquals(Status::ACCEPTED, $actual);
    }
}
