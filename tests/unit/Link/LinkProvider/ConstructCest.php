<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Link\LinkProvider;

use Cardoe\Link\Link;
use Cardoe\Link\LinkProvider;
use Psr\Link\LinkProviderInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Link\LinkProvider :: __construct()
     *
     * @since  2019-06-15
     */
    public function linkLinkProviderConstruct(UnitTester $I)
    {
        $I->wantToTest('Link\LinkProvider - __construct()');

        $links = [
            new Link('canonical', 'https://dev.cardoe.ld'),
            new Link('cite-as', 'https://test.cardoe.ld'),
        ];
        $link  = new LinkProvider($links);

        $class = LinkProviderInterface::class;
        $I->assertInstanceOf($class, $link);
    }
}
