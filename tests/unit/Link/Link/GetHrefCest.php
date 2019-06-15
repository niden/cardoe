<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Link\Link;

use Cardoe\Link\Link;
use UnitTester;

class GetHrefCest
{
    /**
     * Tests Cardoe\Link\Link :: getHref()
     *
     * @since  2019-06-15
     */
    public function linkLinkGetHref(UnitTester $I)
    {
        $I->wantToTest('Link\Link - getHref()');

        $href = 'https://dev.cardoe.ld';
        $link = new Link('payment', $href);

        $I->assertEquals($href, $link->getHref());
    }
}