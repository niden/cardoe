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

class GetSetMessagesCest
{
    /**
     * Unit Tests Cardoe\Domain\Payload\Payload :: getMessages()/setMessages()
     *
     * @since  2019-06-07
     */
    public function httpPayloadPayloadGetSetMessages(UnitTester $I)
    {
        $I->wantToTest('Domain\Payload\Payload - getMessages()/setMessages()');

        $payload = new Payload();
        $payload->setMessages('messages');

        $actual = $payload->getMessages();
        $I->assertEquals('messages', $actual);
    }
}
