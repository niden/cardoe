<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\ConfigFactory;

use Cardoe\Config\Adapter\Ini;
use Cardoe\Config\Adapter\Json;
use Cardoe\Config\Adapter\Php;
use Cardoe\Config\Adapter\Yaml;
use Cardoe\Config\ConfigFactory;
use UnitTester;

use function dataDir;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Logger\LoggerFactory :: newInstance()
     *
     * @since  2019-05-03
     */
    public function configFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Config\ConfigFactory - newInstance()');

        $factory = new ConfigFactory();
        $config  = $factory->newInstance(
            'ini',
            dataDir('assets/config/config.ini')
        );

        $I->assertInstanceOf(Ini::class, $config);

        $config = $factory->newInstance(
            'json',
            dataDir('assets/config/config.json')
        );

        $I->assertInstanceOf(Json::class, $config);

        $config = $factory->newInstance(
            'php',
            dataDir('assets/config/config.php')
        );

        $I->assertInstanceOf(Php::class, $config);

        $config = $factory->newInstance(
            'yaml',
            dataDir('assets/config/config.yml')
        );

        $I->assertInstanceOf(Yaml::class, $config);
    }
}
