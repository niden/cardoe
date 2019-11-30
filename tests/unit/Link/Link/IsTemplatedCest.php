<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Link\Link;

use Cardoe\Link\Link;
use UnitTester;

class IsTemplatedCest
{
    /**
     * Tests Cardoe\Link\Link :: isTemplated()
     *
     * @since  2019-06-15
     */
    public function linkLinkIsTemplated(UnitTester $I)
    {
        $I->wantToTest('Link\Link - isTemplated()');

        $href = 'https://dev.cardoe.ld';
        $link = new Link('payment', $href);

        $I->assertFalse($link->isTemplated());

        $href = 'https://dev.{domain}.ld';
        $link = new Link('payment', $href);

        $I->assertTrue($link->isTemplated());
    }
}
