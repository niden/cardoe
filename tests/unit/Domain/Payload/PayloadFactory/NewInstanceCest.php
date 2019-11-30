<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Domain\Payload\PayloadFactory;

use Cardoe\Domain\Payload\PayloadFactory;
use Cardoe\Domain\Payload\PayloadInterface;
use UnitTester;

class NewInstanceCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\PayloadFactory :: newInstance()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\PayloadFactory - newInstance()');

        $factory = new PayloadFactory();
        $payload = $factory->newInstance();

        $I->assertInstanceOf(
            PayloadInterface::class,
            $payload
        );
    }
}
