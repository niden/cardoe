<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Link\EvolvableLink;

use Cardoe\Link\EvolvableLink;
use Psr\Link\EvolvableLinkInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Link\EvolvableLink :: __construct()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkConstruct(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - __construct()');

        $link = new EvolvableLink();

        $class = EvolvableLinkInterface::class;
        $I->assertInstanceOf($class, $link);
    }
}
