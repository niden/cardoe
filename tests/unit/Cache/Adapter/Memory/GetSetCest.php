<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Memory;

use Cardoe\Cache\Adapter\Memory;
use Cardoe\Storage\SerializerFactory;
use Codeception\Example;
use stdClass;
use UnitTester;

class GetSetCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Memory :: get()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalcon.io>
     * @since        2019-03-31
     */
    public function cacheAdapterMemoryGetSet(UnitTester $I, Example $example)
    {
        $I->wantToTest('Cache\Adapter\Memory - get()/set() - ' . $example[0]);

        $serializer = new SerializerFactory();
        $adapter    = new Memory($serializer);

        $key = uniqid();

        $I->assertTrue(
            $adapter->set($key, $example[1])
        );

        $I->assertEquals(
            $example[1],
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
                'boolean',
                true,
            ],
            [
                'object',
                new stdClass(),
            ],
        ];
    }
}
