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

class WithHrefCest
{
    /**
     * Tests Cardoe\Link\Link :: withHref()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkWithHref(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - withHref()');

        $href = 'https://dev.cardoe.ld';
        $link = new EvolvableLink('payment', $href);

        $I->assertEquals($href, $link->getHref());

        $href        = 'https://test.cardoe.ld';
        $newInstance = $link->withHref($href);

        $I->assertNotSame($link, $newInstance);

        $I->assertEquals($href, $newInstance->getHref());
    }
}
