<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Storage\Unserializer\Php;

use Cardoe\Storage\Serializer\Php;
use Codeception\Example;
use stdClass;
use UnitTester;

class UnserializeCest
{
    /**
     * Tests Cardoe\Storage\Unserializer\Php :: unserialize()
     *
     * @dataProvider getExamples
     *
     * @author       Cardoe Team <team@phalconphp.com>
     * @since        2019-03-30
     */
    public function storageSerializerPhpUnserialize(UnitTester $I, Example $example)
    {
        $I->wantToTest('Storage\Unserializer\Php - unserialize() - ' . $example[0]);

        $serializer = new Php();

        $expected = $example[1];

        $serializer->unserialize($example[2]);

        $I->assertEquals(
            $expected,
            $serializer->getData()
        );
    }

    private function getExamples(): array
    {
        return [
            [
                'null',
                null,
                null,
            ],
            [
                'true',
                true,
                true,
            ],
            [
                'false',
                false,
                false,
            ],
            [
                'integer',
                1234,
                1234,
            ],
            [
                'float',
                1.234,
                1.234,
            ],
            [
                'string',
                'Cardoe Framework',
                serialize('Cardoe Framework'),
            ],
            [
                'array',
                ['Cardoe Framework'],
                serialize(['Cardoe Framework']),
            ],
            [
                'object',
                new stdClass(),
                serialize(new stdClass()),
            ],
        ];
    }
}
