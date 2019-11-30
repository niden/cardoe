<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Link\EvolvableLink;

use Cardoe\Link\EvolvableLink;
use UnitTester;

class GetHrefCest
{
    /**
     * Tests Cardoe\Link\Link :: getHref()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkGetHref(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - getHref()');

        $href = 'https://dev.cardoe.ld';
        $link = new EvolvableLink('payment', $href);

        $I->assertEquals($href, $link->getHref());
    }
}
