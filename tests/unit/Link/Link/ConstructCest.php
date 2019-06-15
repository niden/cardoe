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
use Psr\Link\LinkInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Link\Link :: __construct()
     *
     * @since  2019-06-15
     */
    public function linkLinkConstruct(UnitTester $I)
    {
        $I->wantToTest('Link\Link - __construct()');

        $link = new Link('payment', 'https://dev.cardoe.ld');

        $class = LinkInterface::class;
        $I->assertInstanceOf($class, $link);
    }
}
