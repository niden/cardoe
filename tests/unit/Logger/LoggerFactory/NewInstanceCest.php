<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\LoggerFactory;

use Cardoe\Logger\AdapterFactory;
use Cardoe\Logger\Logger;
use Cardoe\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use UnitTester;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Logger\LoggerFactory :: newInstance()
     *
     * @since  2019-05-03
     */
    public function loggerLoggerFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Logger\LoggerFactory - newInstance()');

        $factory = new LoggerFactory(
            new AdapterFactory()
        );

        $logger = $factory->newInstance('my-logger');

        $I->assertInstanceOf(
            Logger::class,
            $logger
        );

        $I->assertInstanceOf(
            LoggerInterface::class,
            $logger
        );
    }
}
