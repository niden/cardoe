<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerUploadedFileFactory;

use Cardoe\Http\Message\UploadedFileFactory;
use Psr\Http\Message\UploadedFileFactoryInterface;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Cardoe\Http\Message\ServerUploadedFileFactory :: __construct()
     *
     * @since  2019-02-08
     */
    public function httpUploadedFileFactoryConstruct(UnitTester $I)
    {
        $I->wantToTest('Http\UploadedFileFactory - __construct()');

        $factory = new UploadedFileFactory();
        $class   = UploadedFileFactoryInterface::class;
        $I->assertInstanceOf($class, $factory);
    }
}
