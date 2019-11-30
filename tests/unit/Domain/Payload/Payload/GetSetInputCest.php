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

class GetSetInputCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getInput()/setInput()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetSetInput(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getInput()/setInput()');

        $payload = new Payload();
        $payload->setInput('input');

        $actual = $payload->getInput();
        $I->assertEquals('input', $actual);
    }
}
