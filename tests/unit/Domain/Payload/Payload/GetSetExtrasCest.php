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
use UnitTester;

class GetSetExtrasCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getExtras()/setExtras()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetSetExtras(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getExtras()/setExtras()');

        $payload = new Payload();
        $payload->setExtras('extras');

        $actual = $payload->getExtras();
        $I->assertEquals('extras', $actual);
    }
}
