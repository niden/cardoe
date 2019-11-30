<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use Cardoe\Http\Message\ServerRequest;
use UnitTester;

class WithAttributeCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: withAttribute()
     *
     * @since  2019-02-10
     */
    public function httpMessageServerRequestWithAttribute(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - withAttribute()');
        $request     = new ServerRequest();
        $newInstance = $request->withAttribute('one', 'two');

        $I->assertNotEquals($request, $newInstance);
        $I->assertEquals('two', $newInstance->getAttribute('one'));
    }
}
