<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was $containerstributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Fixtures\Container;

use Phalcon\Container;
use Phalcon\Container\Config;

/**
 * Class ConfigLibraryFixtureClass
 */
class ConfigLibraryFixtureClass extends Config
{
    public function define(Container $container): void
    {
        parent::define($container);

        $container->set('library', (object) ['name' => 'seven']);
    }

    public function modify(Container $container): void
    {
        parent::modify($container);

        $container->get('library')->name = 'tuvok';
    }
}
