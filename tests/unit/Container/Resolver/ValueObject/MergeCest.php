<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Resolver\ValueObject;

use Phalcon\Container\Resolver\ValueObject;
use UnitTester;

class MergeCest
{
    /**
     * Unit Tests Phalcon\Container\Resolver\ValueObject :: merge()
     *
     * @since  2019-12-30
     */
    public function containerResolverValueObjectMerge(UnitTester $I)
    {
        $I->wantToTest('Container\Resolver\ValueObject - merge()');

        $collection = new ValueObject();

        $collection->set('one', ['two', 'three']);

        $source = [
            'four',
            'five',
        ];

        $I->assertTrue($collection->has('one'));

        $collection->merge('one', $source);

        $I->assertEquals(
            [
                'four',
                'five',
            ],
            $collection->get('one')
        );
    }
}
