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
use Psr\Link\EvolvableLinkProviderInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Link\EvolvableLinkProvider :: __construct()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkConstruct(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLinkProvider - __construct()');

        $link = new EvolvableLinkProvider();

        $class = EvolvableLinkProviderInterface::class;
        $I->assertInstanceOf($class, $link);
    }
}