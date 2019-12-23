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
use UnitTester;

class GetHrefCest
{
    /**
     * Tests Phalcon\Html\Link\Link :: getHref()
     *
     * @since  2019-06-15
     */
    public function htmlLinkEvolvableLinkGetHref(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - getHref()');

        $href = 'https://dev.cardoe.ld';
        $link = new EvolvableLink('payment', $href);

        $I->assertEquals($href, $link->getHref());
    }
}
