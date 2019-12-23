<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Link\EvolvableLink;

use Phalcon\Html\Link\EvolvableLink;
use Psr\Link\EvolvableLinkInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Phalcon\Html\Link\EvolvableLink :: __construct()
     *
     * @since  2019-06-15
     */
    public function htmlLinkEvolvableLinkConstruct(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - __construct()');

        $link = new EvolvableLink();

        $class = EvolvableLinkInterface::class;
        $I->assertInstanceOf($class, $link);
    }
}
