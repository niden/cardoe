<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Serializer\Igbinary;

use Cardoe\Storage\Serializer\Igbinary;
use Codeception\Example;
use stdClass;
use UnitTester;
use function igbinary_serialize;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Serializer\Igbinary :: unserialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalconphp.com>
     * @since        2019-03-30
     */
    public function storageSerializerIgbinaryUnserialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Serializer\Igbinary - unserialize() - ' . $example[0]);
        $serializer = new Igbinary();
        $serialized = igbinary_serialize($example[1]);
        $serializer->unserialize($serialized);

        $expected = $example[1];
        $actual   = $serializer->getData();
        $I->assertEquals($expected, $actual);
    }

    private function getExamples(): array
    {
        return [
            [
                'integer',
                1234,
            ],
            [
                'float',
                1.234,
            ],
            [
                'string',
                'Cardoe Framework',
            ],
            [
                'array',
                ['Cardoe Framework'],
            ],
            [
                'object',
                new stdClass(),
            ],
        ];
    }
}
