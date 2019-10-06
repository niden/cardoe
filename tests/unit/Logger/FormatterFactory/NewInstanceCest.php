<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\FormatterFactory;

use Cardoe\Logger\AdapterFactory;
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Json;
use Cardoe\Logger\FormatterFactory;
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
        $I->wantToTest('Logger\FormatterFactory - newInstance()');

        $factory = new FormatterFactory();

        $formatter = $factory->newInstance('json');

        $I->assertInstanceOf(Json::class, $formatter);
        $I->assertInstanceOf(FormatterInterface::class, $formatter);
    }
}
