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

use function array_pop;
use function spl_autoload_functions;

class RegisterUnregisterCest
{
    use LoaderTrait;

    /**
     * Tests Cardoe\Autoload\Loader :: register()/unregister()
     *
     * @since  2018-11-13
     */

    public function autoloaderLoaderRegisterUnregister(UnitTester $I)
    {
        $I->wantToTest('Autoload\Loader - register()/unregister()');

        $loader = new Loader();
        $loader->register();

        $functions = spl_autoload_functions();
        $item      = array_pop($functions);

        $I->assertSame($loader, $item[0]);
        $I->assertEquals('autoload', $item[1]);

        $loader->unregister();
    }
}
