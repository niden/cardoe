<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Link\EvolvableLinkProvider;

use Cardoe\Link\EvolvableLinkProvider;
use Cardoe\Link\Link;
use UnitTester;

class GetLinksByRelCest
{
    /**
     * Tests Cardoe\Link\EvolvableLinkProvider :: getLinksByRel()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkProviderGetLinksByRel(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLinkProvider - getLinksByRel()');

        $links = [
            new Link('canonical', 'https://dev.cardoe.ld'),
            new Link('cite-as', 'https://test.cardoe.ld'),
        ];
        $link  = new EvolvableLinkProvider($links);

        $expected = [
            $links[1],
        ];

        $I->assertEquals($expected, $link->getLinksByRel('cite-as'));
        $I->assertEquals([], $link->getLinksByRel('unknown'));
    }
}
