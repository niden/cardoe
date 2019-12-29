<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\Mutator\Mutator;

use Phalcon\Container;
use Phalcon\Container\Mutator\Mutator;
use ReflectionClass;
use UnitTester;

class SetPropertiesCest
{
    /**
     * Unit Tests Phalcon\Container\Mutator\Mutator :: setProperties()
     *
     * @since  2019-12-29
     */
    public function containerMutatorMutatorSetProperties(UnitTester $I)
    {
        $I->wantToTest('Container\Mutator\Mutator - setProperties()');

        $container = new Container();
        $mutator   = new Mutator('CrewClass');
        $mutator->setContainer($container);

        $source = [
            'name'     => 'Seven',
            'lastName' => 'of Nine',
        ];
        $mutator->setProperties($source);

        $reflection = new ReflectionClass($mutator);
        $properties = $reflection->getProperty('properties');
        $properties->setAccessible(true);

        $I->assertEquals($source, $properties->getValue($mutator));
    }
}
