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

class WithoutAttributeCest
{
    /**
     * Tests Cardoe\Link\Link :: withoutAttribute()
     *
     * @since  2019-06-15
     */
    public function linkEvolvableLinkWithoutAttribute(UnitTester $I)
    {
        $I->wantToTest('Link\EvolvableLink - withoutAttribute()');

        $href       = 'https://dev.cardoe.ld';
        $attributes = [
            'one'   => true,
            'two'   => 123,
            'three' => 'four',
            'five'  => [
                'six',
                'seven',
            ],
        ];
        $link       = new EvolvableLink('payment', $href, $attributes);

        $I->assertEquals($attributes, $link->getAttributes());

        $newInstance = $link->withoutAttribute('five');

        unset($attributes['five']);

        $I->assertEquals($attributes, $newInstance->getAttributes());
    }
}
