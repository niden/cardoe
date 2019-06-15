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
use UnitTester;

class WithoutRelCest
{
    /**
     * Tests Cardoe\Link\Link :: withoutRel()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkWithoutRel(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - withoutRel()');

        $href = 'https://dev.cardoe.ld';
        $link = new EvolvableLink('payment', $href);

        $I->assertEquals(['payment'], $link->getRels());

        $newInstance = $link
            ->withRel('citation')
            ->withRel('canonical')
        ;

        $I->assertNotSame($link, $newInstance);

        $rels = [
            'payment',
            'citation',
            'canonical',
        ];
        $I->assertEquals($rels, $newInstance->getRels());

        $newInstance = $newInstance->withoutRel('citation');

        $rels = [
            'payment',
            'canonical',
        ];
        $I->assertEquals($rels, $newInstance->getRels());
    }
}
