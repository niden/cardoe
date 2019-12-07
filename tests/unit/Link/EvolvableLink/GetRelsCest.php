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

class GetRelsCest
{
    /**
     * Tests Cardoe\Link\Link :: getRels()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkGetRels(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - getRels()');

        $href = 'https://dev.cardoe.ld';
        $link = new EvolvableLink('payment', $href);

        $expected = ['payment'];
        $I->assertEquals($expected, $link->getRels());
    }
}
