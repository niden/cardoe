<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Autoload\Loader;

use Cardoe\Autoload\Loader;
use Cardoe\Test\Fixtures\Traits\LoaderTrait;
use UnitTester;

class GetAddSetExtensionsCest
{
    use LoaderTrait;

    /**
     * Tests Cardoe\Autoload\Loader ::
     * getExtensions()/addExtension()/setExtension()
     *
     * @since  2018-11-13
     */
    public function autoloaderLoaderGetAddSetExtensions(UnitTester $I)
    {
        $I->wantToTest('Autoload\Loader - getExtensions()/addExtension()/setExtension()');

        $loader = new Loader();

        $I->assertEquals(
            [
                'php',
            ],
            $loader->getExtensions()
        );

        $loader->setExtensions(
            [
                'inc',
                'inc',
                'inc',
            ]
        );
        $I->assertEquals(
            [
                'php',
                'inc',
            ],
            $loader->getExtensions()
        );

        /**
         * Clear
         */
        $loader->setExtensions([]);
        $I->assertEquals(
            [
                'php',
            ],
            $loader->getExtensions()
        );

        $loader
            ->addExtension('inc')
            ->addExtension('phpt')
            ->addExtension('inc')
        ;
        $I->assertEquals(
            [
                'php',
                'inc',
                'phpt',
            ],
            $loader->getExtensions()
        );
    }
}
