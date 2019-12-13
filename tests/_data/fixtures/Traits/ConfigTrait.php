<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Traits;

use Cardoe\Config\Adapter\Grouped;
use Cardoe\Config\Adapter\Ini;
use Cardoe\Config\Adapter\Json;
use Cardoe\Config\Adapter\Php;
use Cardoe\Config\Adapter\Yaml;
use Cardoe\Config\Config;
use Cardoe\Config\Exception;
use UnitTester;

use function dataDir;

trait ConfigTrait
{
    /**
     * @var array
     */
    protected $config = [
        'cardoe'      => [
            'baseuri' => '/cardoe/',
        ],
        'models'      => [
            'metadata' => 'memory',
        ],
        'database'    => [
            'adapter'  => 'mysql',
            'host'     => 'localhost',
            'username' => 'user',
            'password' => 'passwd',
            'name'     => 'demo',
        ],
        'test'        => [
            'parent' => [
                'property'  => 1,
                'property2' => 'yeah',
            ],
        ],
        'issue-12725' => [
            'channel' => [
                'handlers' => [
                    0 => [
                        'name'           => 'stream',
                        'level'          => 'debug',
                        'fingersCrossed' => 'info',
                        'filename'       => 'channel.log',
                    ],
                    1 => [
                        'name'           => 'redis',
                        'level'          => 'debug',
                        'fingersCrossed' => 'info',
                    ],
                ],
            ],
        ],
    ];

    /**
     * Tests Cardoe\Config\Adapter\* :: __construct()
     *
     * @since  2018-11-13
     */
    private function checkConstruct(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'construct'
            )
        );

        $config = $this->getConfig($adapter);

        $this->compareConfig($I, $this->config, $config);
    }

    /**
     * Returns the message to print out for the test
     *
     * @param string $adapter
     *
     * @return string
     */
    private function getMessage(string $adapter = ''): string
    {
        $class = '';

        if ('' !== $adapter) {
            $class = sprintf('\Adapter\%s', $adapter);
        }

        return 'Config' . $class . ' - %s';
    }

    /**
     * Returns a config object
     *
     * @param string $adapter
     *
     * @return Grouped|Ini|Json|Php|Yaml|Config
     * @throws Exception
     */
    private function getConfig(string $adapter = '')
    {
        switch ($adapter) {
            case 'Ini':
                return new Ini(
                    dataDir('assets/config/config.ini')
                );

            case 'Json':
                return new Json(
                    dataDir('assets/config/config.json')
                );

            case 'Php':
                return new Php(
                    dataDir('assets/config/config.php')
                );

            case 'Yaml':
                return new Yaml(
                    dataDir('assets/config/config.yml')
                );

            case 'Grouped':
                $config = [
                    dataDir('assets/config/config.php'),
                    [
                        'adapter'  => 'json',
                        'filePath' => dataDir('assets/config/config.json'),
                    ],
                    [
                        'adapter' => 'array',
                        'config'  => [
                            'test' => [
                                'property2' => 'something-else',
                            ],
                        ],
                    ],
                ];

                return new Grouped($config);

            default:
                return new Config($this->config);
        }
    }

    private function compareConfig(UnitTester $I, array $actual, Config $expected)
    {
        $I->assertEquals(
            $expected->toArray(),
            $actual
        );

        foreach ($actual as $key => $value) {
            $I->assertTrue(
                isset($expected->$key)
            );

            if (is_array($value)) {
                $this->compareConfig($I, $value, $expected->$key);
            }
        }
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: count()
     *
     * @author Faruk Brbovic <fbrbovic@devstub.com>
     * @since  2014-11-03
     */
    private function checkCount(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'count()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertEquals(
            5,
            $config->count()
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: get()
     *
     * @since  2018-11-13
     */
    private function checkGet(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'get()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertEquals(
            'memory',
            $config->get('models')->get('metadata')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: getPathDelimiter()
     *
     * @since  2018-11-13
     */
    private function checkGetPathDelimiter(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'getPathDelimiter()'
            )
        );

        $config = $this->getConfig($adapter);

        $existing = $config->getPathDelimiter();


        $I->assertEquals(
            '.',
            $config->getPathDelimiter()
        );


        $config->setPathDelimiter('/');

        $I->assertEquals(
            '/',
            $config->getPathDelimiter()
        );


        $config->setPathDelimiter($existing);
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: merge() - exception
     *
     * @since  2019-06-19
     */
    private function checkMergeException(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'merge()'
            )
        );

        $config = $this->getConfig($adapter);
        $I->expectThrowable(
            new Exception(
                'Invalid data type for merge.'
            ),
            function () use ($config) {
                $config->merge(false);
            }
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: offsetExists()
     *
     * @since  2018-11-13
     */
    private function checkOffsetExists(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'offsetExists()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertTrue(
            $config->offsetExists('models')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: offsetGet()
     *
     * @since  2018-11-13
     */
    private function checkOffsetGet(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'offsetGet()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertEquals(
            'memory',
            $config->offsetGet('models')->offsetGet('metadata')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: offsetSet()
     *
     * @since  2018-11-13
     */
    private function checkOffsetSet(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'offsetSet()'
            )
        );

        $config = $this->getConfig($adapter);

        $config->offsetSet('models', 'something-else');

        $I->assertEquals(
            'something-else',
            $config->offsetGet('models')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: offsetUnset()
     *
     * @since  2018-11-13
     */
    private function checkOffsetUnset(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'offsetUnset()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertTrue(
            $config->offsetExists('database')
        );

        $config->offsetUnset('database');

        $I->assertFalse(
            $config->offsetExists('database')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: path()
     *
     * @author michanismus
     * @since  2017-03-29
     */
    private function checkPath(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'path()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertCount(
            1,
            $config->path('test')
        );


        $I->assertEquals(
            'yeah',
            $config->path('test.parent.property2')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: path() - default
     *
     * @since  2018-11-13
     */
    private function checkPathDefault(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'path() - default'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertEquals(
            'Unknown',
            $config->path('test.parent.property3', 'Unknown')
        );
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: setPathDelimiter()
     *
     * @since  2018-11-13
     */
    private function checkSetPathDelimiter(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'setPathDelimiter()'
            )
        );

        $config = $this->getConfig($adapter);

        $existing = $config->getPathDelimiter();

        $I->assertEquals(
            'yeah',
            $config->path('test.parent.property2', 'Unknown')
        );

        $config->setPathDelimiter('/');

        $I->assertEquals(
            'Unknown',
            $config->path('test.parent.property2', 'Unknown')
        );

        $I->assertEquals(
            'yeah',
            $config->path('test/parent/property2', 'Unknown')
        );

        $config->setPathDelimiter($existing);
    }

    /**
     * Tests Cardoe\Config\Adapter\* :: toArray()
     *
     * @since  2018-11-13
     */
    private function checkToArray(UnitTester $I, string $adapter = '')
    {
        $I->wantToTest(
            sprintf(
                $this->getMessage($adapter),
                'toArray()'
            )
        );

        $config = $this->getConfig($adapter);

        $I->assertEquals(
            $this->config,
            $config->toArray()
        );
    }
}
