<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Link\EvolvableLinkProvider;

use Cardoe\Link\EvolvableLinkProvider;
use Cardoe\Link\Link;
use UnitTester;
use function spl_object_hash;

class GetLinksCest
{
    /**
     * Tests Cardoe\Link\EvolvableLinkProvider :: getLinks()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkProviderGetLinks(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLinkProvider - getLinks()');

        $links = [
            new Link('canonical', 'https://dev.cardoe.ld'),
            new Link('cite-as', 'https://test.cardoe.ld'),
        ];
        $link  = new EvolvableLinkProvider($links);

        $expected = [
            spl_object_hash($links[0]) => $links[0],
            spl_object_hash($links[1]) => $links[1],
        ];

        $I->assertEquals($expected, $link->getLinks());
    }
}
