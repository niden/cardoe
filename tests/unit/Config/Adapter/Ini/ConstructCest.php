<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Ini;

use Cardoe\Config\Adapter\Ini;
use Cardoe\Config\Exception;
use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

use function dataDir;

class ConstructCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Ini :: __construct()
     *
     * @since  2018-11-13
     */
    public function configAdapterIniConstruct(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Ini - construct');

        $this->config['database']['num1'] = false;
        $this->config['database']['num2'] = false;
        $this->config['database']['num3'] = false;
        $this->config['database']['num4'] = true;
        $this->config['database']['num5'] = true;
        $this->config['database']['num6'] = true;
        $this->config['database']['num7'] = null;
        $this->config['database']['num8'] = 123;
        $config                           = $this->getConfig('Ini');

        $this->compareConfig($I, $this->config, $config);
    }


    /**
     * Tests Cardoe\Config\Adapter\Ini :: __construct() - constants
     *
     * @since  2018-11-13
     */
    public function configAdapterIniConstructConstants(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Ini - construct - constants');

        define('TEST_CONST', 'foo');

        $config = new Ini(
            dataDir('assets/config/config-with-constants.ini'),
            INI_SCANNER_NORMAL
        );

        $expected = [
            'test'    => 'foo',
            'path'    => 'foo/something/else',
            'section' => [
                'test'      => 'foo',
                'path'      => 'foo/another-thing/somewhere',
                'parent'    => [
                    'property'  => 'foo',
                    'property2' => 'foohello',
                ],
                'testArray' => [
                    'value1',
                    'value2',
                ],
            ],

        ];

        $I->assertEquals(
            $expected,
            $config->toArray()
        );
    }
}
