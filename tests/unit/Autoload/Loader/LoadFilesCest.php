<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Autoload\Loader;

use Cardoe\Autoload\Loader;
use Cardoe\Test\Fixtures\Traits\LoaderTrait;
use UnitTester;

use function dataDir;
use function function_exists;

class LoadFilesCest
{
    /**
     * Unit Tests Cardoe\Autoload\Loader :: loadFiles()
     *
     * @since  2019-11-30
     */
    public function autoloadLoaderLoadFiles(UnitTester $I)
    {
        $I->wantToTest('Autoload\Loader - loadFiles()');

        $loader = new Loader();

        $I->assertFalse(
            function_exists('noClassFoo')
        );

        $I->assertFalse(
            function_exists('noClassBar')
        );

        $loader
            ->addFile(
                dataDir('fixtures/Loader/Example/Functions/FunctionsNoClass.php')
            )
            ->addFile(
                '/path/to/unknown/file'
            )
        ;

        $loader->loadFiles();

        $I->assertTrue(
            function_exists('noClassFoo')
        );

        $I->assertTrue(
            function_exists('noClassBar')
        );
    }
}
