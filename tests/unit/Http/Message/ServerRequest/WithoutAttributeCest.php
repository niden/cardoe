<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class WithoutAttributeCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withoutAttribute()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithoutAttribute(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withoutAttribute()');

        $request = (new ServerRequest())
            ->withAttribute('one', 'two')
            ->withAttribute('three', 'four')
        ;

        $newInstance = $request->withoutAttribute('one');

        $I->assertNotEquals($request, $newInstance);

        $I->assertEquals(
            [
                'three' => 'four',
            ],
            $newInstance->getAttributes()
        );
    }
}
