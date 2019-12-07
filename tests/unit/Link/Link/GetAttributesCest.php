<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Link\Link;

use Cardoe\Link\Link;
use UnitTester;

class GetAttributesCest
{
    /**
     * Tests Cardoe\Link\Link :: getAttributes()
     *
     * @since  2019-06-15
     */
    public function linkLinkGetAttributes(UnitTester $I)
    {
        $I->wantToTest('Link\Link - getAttributes()');

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
        $link       = new Link('payment', $href, $attributes);

        $I->assertEquals($attributes, $link->getAttributes());
    }
}
