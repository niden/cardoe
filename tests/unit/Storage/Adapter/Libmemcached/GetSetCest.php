<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use Codeception\Example;
use stdClass;
use UnitTester;

use function getOptionsLibmemcached;

class GetSetCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: get()/set()
     *
     * @dataProvider getExamples
     *
     * @throws Exception
     * @since        2019-03-31
     *
     * @author       Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterLibmemcachedGetSet(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - get()/set() - ' . $example[0]);

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $key = 'cache-data';

        $I->assertTrue(
            $adapter->set($key, $example[1])
        );

        $expected = $example[1];

        $I->assertEquals(
            $expected,
            $adapter->get($key)
        );
    }

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: get()/set() - custom
     * serializer
     *
     * @throws Exception
     * @since  2019-04-29
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function storageAdapterLibmemcachedGetSetCustomSerializer(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - get()/set() - custom serializer');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            array_merge(
                getOptionsLibmemcached(),
                [
                    'defaultSerializer' => 'Base64',
                ]
            )
        );

        $key    = 'cache-data';
        $source = 'Cardoe Framework';

        $I->assertTrue(
            $adapter->set($key, $source)
        );

        $I->assertEquals(
            $source,
            $adapter->get($key)
        );
    }

    private function getExamples(): array
    {
        return [
            [
                'string',
                'random string',
            ],
            [
                'integer',
                123456,
            ],
            [
                'float',
                123.456,
            ],
            [
                'boolean true',
                true,
            ],
            [
                'boolean false',
                false,
            ],
            [
                'null',
                null,
            ],
            [
                'object',
                new stdClass(),
            ],
        ];
    }
}
