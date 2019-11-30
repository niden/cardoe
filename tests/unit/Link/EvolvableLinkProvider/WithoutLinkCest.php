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
use function spl_object_hash;

class WithoutLinkCest
{
    /**
     * Tests Cardoe\Link\EvolvableLinkProvider :: withoutLink()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkProviderWithoutLink(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLinkProvider - withoutLink()');

        $link1    = new Link('canonical', 'https://dev.cardoe.ld');
        $link2    = new Link('cite-as', 'https://test.cardoe.ld');
        $instance = new EvolvableLinkProvider(
            [
                $link1,
                $link2,
            ]
        );

        $newInstance = $instance->withoutLink($link1);

        $I->assertNotSame($instance, $newInstance);

        $expected = [spl_object_hash($link2) => $link2];

        $I->assertEquals($expected, $newInstance->getLinks());
    }
}
