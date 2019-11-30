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
use UnitTester;

class GetSetOutputCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getOutput()/setOutput()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetSetOutput(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getOutput()/setOutput()');

        $payload = new Payload();
        $payload->setOutput('output');

        $actual = $payload->getOutput();
        $I->assertEquals('output', $actual);
    }
}
