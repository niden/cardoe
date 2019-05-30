<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\UriFactory;

use Cardoe\Http\Message\UriFactory;
use Psr\Http\Message\UriFactoryInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\UriFactory :: __construct()
     *
     * @since  2019-02-07
     */
    public function httpUriFactoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\UriFactory - __construct()');

        $factory = new UriFactory();
        $class   = UriFactoryInterface::class;
        $I->assertInstanceOf($class, $factory);
    }
}
