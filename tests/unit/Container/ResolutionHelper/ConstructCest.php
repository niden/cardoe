<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Container\ResolutionHelper;

use Codeception\Stub;
use Codeception\Stub\Expected;
use Phalcon\Container;
use Phalcon\Container\ResolutionHelper;
use stdClass;
use UnitTester;

class ConstructCest
{
    /**
     * Unit Tests Phalcon\Container\ResolutionHelper :: __construct() - string
     *
     * @since  2019-12-30
     */
    public function containerResolutionHelperConstructString(UnitTester $I)
    {
        $I->wantToTest('Container\ResolutionHelper - __construct() - string');

        $source    = 'voyager';
        $instance  = new stdClass();
        $container = $this->getHasContainer($source, $instance);
        $helper    = new ResolutionHelper($container);
        $I->assertEquals($instance, call_user_func($helper, $source));
    }

    /**
     * Unit Tests Phalcon\Container\ResolutionHelper :: __construct() - array
     *
     * @since  2019-12-30
     */
    public function containerResolutionHelperConstructArray(UnitTester $I)
    {
        $I->wantToTest('Container\ResolutionHelper - __construct() - array');

        $class     = 'unknown';
        $source    = [$class, 'voyager'];
        $instance  = new stdClass();
        $container = $this->getHasNotContainer(
            $class,
            $instance
        );

        $helper = new ResolutionHelper($container);
        $I->assertEquals(
            [$instance, 'voyager'],
            call_user_func($helper, $source)
        );
    }

    /**
     * Unit Tests Phalcon\Container\ResolutionHelper :: __construct() - array
     * service
     *
     * @since  2019-12-30
     */
    public function containerResolutionHelperConstructArrayService(UnitTester $I)
    {
        $I->wantToTest('Container\ResolutionHelper - __construct() - array service');

        $class     = 'unknown';
        $source    = [$class, 'voyager'];
        $instance  = new stdClass();
        $container = $this->getHasContainer(
            $class,
            $instance
        );

        $helper = new ResolutionHelper($container);
        $I->assertEquals(
            [$instance, 'voyager'],
            call_user_func($helper, $source)
        );
    }

    /**
     * Unit Tests Phalcon\Container\ResolutionHelper :: __construct() - object
     *
     * @since  2019-12-30
     */
    public function containerResolutionHelperConstructObject(UnitTester $I)
    {
        $I->wantToTest('Container\ResolutionHelper - __construct() - object');

        $source    = (object) ['starship', 'voyager'];
        $container = Stub::make(
            Container::class,
            [
                'get'         => Expected::never(),
                'newInstance' => Expected::never(),
            ]
        );

        $helper = new ResolutionHelper($container);
        $I->assertEquals(
            $source,
            call_user_func($helper, $source)
        );
    }

    /**
     * @param mixed $source
     * @param mixed $instance
     *
     * @return object
     * @throws \Exception
     */
    private function getHasContainer($source, $instance)
    {
        return Stub::make(
            Container::class,
            [
                'get'         => function ($param) use ($source, $instance) {
                    if ($source === $param) {
                        return $instance;
                    }

                    return null;
                },
                'has'         => function ($param) use ($source) {
                    return ($source === $param);
                },
                'newInstance' => Expected::never(),
            ]
        );
    }

    /**
     * @param mixed $source
     * @param mixed $instance
     *
     * @return object
     * @throws \Exception
     */
    private function getHasNotContainer($source, $instance)
    {
        return Stub::make(
            Container::class,
            [
                'get'         => Expected::never(),
                'has'         => function ($param) use ($source) {
                    return ($source !== $param);
                },
                'newInstance' => function ($param) use ($source, $instance) {
                    if ($source === $param) {
                        return $instance;
                    }

                    return null;
                },
            ]
        );
    }
}
