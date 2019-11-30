<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Autoload\Loader;

use Cardoe\Autoload\Exception;
use Cardoe\Autoload\Loader;
use Cardoe\Test\Fixtures\Traits\LoaderTrait;
use UnitTester;

class GetAddSetNamespacesCest
{
    use LoaderTrait;

    /**
     * Tests Cardoe\Autoload\Loader ::
     * getNamespaces()/addNamespace()/setNamespace()
     *
     * @throws Exception
     * @since  2018-11-13
     */
    public function autoloadLoaderGetAddSetNamespaces(UnitTester $I)
    {
        $I->wantToTest('Autoload\Loader - getNamespaces()/addNamespace()/setNamespace()');

        $loader = new Loader();

        $I->assertEquals(
            [],
            $loader->getNamespaces()
        );

        $loader->setNamespaces(
            [
                'Cardoe\Loader'   => '/path/to/loader',
                'Cardoe\Provider' => [
                    '/path/to/provider/source',
                    '/path/to/provider/target',
                ],
            ]
        );
        $I->assertEquals(
            [
                'Cardoe\Loader\\'   => [
                    '/path/to/loader/',
                ],
                'Cardoe\Provider\\' => [
                    '/path/to/provider/source/',
                    '/path/to/provider/target/',
                ],
            ],
            $loader->getNamespaces()
        );

        /**
         * Clear
         */
        $loader->setNamespaces([]);
        $I->assertEquals(
            [],
            $loader->getNamespaces()
        );

        $loader
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/loader'
            )
            ->addNamespace(
                'Cardoe\Provider',
                [
                    '/path/to/provider/source',
                    '/path/to/provider/target',
                ]
            )
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/loader'
            )
        ;
        $I->assertEquals(
            [
                'Cardoe\Loader\\'   => [
                    '/path/to/loader/',
                ],
                'Cardoe\Provider\\' => [
                    '/path/to/provider/source/',
                    '/path/to/provider/target/',
                ],
            ],
            $loader->getNamespaces()
        );

        /**
         * Clear - prepend
         */
        $loader->setNamespaces([]);
        $I->assertEquals(
            [],
            $loader->getNamespaces()
        );

        $loader
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/loader'
            )
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/provider/source'
            )
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/provider/target',
                true
            )
            ->addNamespace(
                'Cardoe\Loader',
                '/path/to/provider/source'
            )
        ;
        $I->assertEquals(
            [
                'Cardoe\Loader\\' => [
                    '/path/to/provider/target/',
                    '/path/to/loader/',
                    '/path/to/provider/source/',
                ],
            ],
            $loader->getNamespaces()
        );
    }

    /**
     * Tests Cardoe\Autoload\Loader ::
     * getNamespaces()/addNamespace()/setNamespace() - exception
     *
     * @since  2018-11-13
     */
    public function autoloadLoaderGetAddSetNamespacesException(UnitTester $I)
    {
        $I->wantToTest(
            'Autoload\Loader - getNamespaces()/addNamespace()/setNamespace() - exception'
        );

        $I->expectThrowable(
            new Exception(
                'The directories parameter is not a string or array'
            ),
            function () {
                $loader = new Loader();
                $loader
                    ->addNamespace('Cardoe\Loader', 1234);
            }
        );
    }
}
